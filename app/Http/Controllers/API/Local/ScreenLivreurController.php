<?php

namespace App\Http\Controllers\API\Local;

use App\Models\User;
use App\Models\Client;
use App\Models\Livreur;
use App\Models\Boutique;
use App\Models\Commande;
use App\Models\Template;
use App\Models\Messagerie;
use App\Models\TeamExpense;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ApiMessagerie;
use App\Models\StatutLivraison;
use App\Models\LivreurCommandes;
use App\Models\SocieteTransport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\LivreurConfirmationMail;
use Illuminate\Support\Facades\Event;
use App\Events\LivreurCommandeStatusUpdated;
use Vonage\Client as VonageClient;
use Maatwebsite\Excel\Facades\Excel;
use Vonage\Client\Credentials\Basic as VonageCredentials;

class ScreenLivreurController extends Controller
{
    /*
    *constructor
    */
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {

        $user = auth('api')->user();

        $livreur = Livreur::where('user_id', $user->id)->firstOrFail();
        // Récupérer les commandes assignées à ce livreur
        $commandes = LivreurCommandes::where('livreur_id', $livreur->id)->with('statutLivraison')->get();
        // return response()->json(['commandes' => $commandes]);

        
        //Pour afficher details des commandes associes au livreur
        
        $societe = SocieteTransport::where('id', $livreur->societeTransport_id)->with('boutique')->firstOrFail();
        $boutique = $societe->boutique;
        $orders = [];
        
        foreach($commandes as $commande){
            $order = (new OrderController)->show($boutique->id, $commande->order_id);
            $order = json_decode(json_encode($order), true);
            $ordersGlobal[] = $order['original']; // Ajouter le tableau 'original' de chaque commande à $ordersGlobal
             // Vérifier si la commande a un statut de livraison associé, sinon, attribuer un tableau vide par défaut
            $commande->load('statutLivraison');
            if (!$commande->statutLivraison) {
                $commande->statutLivraison = [];
             }
        }
        $orders = $ordersGlobal; // Affecter $ordersGlobal à $orders

        // Passer les données à la vue
        return response()->json(['commandes' => $orders, 'livreur_commande'=>$commandes,'boutique'=>$boutique]);
    
    }
    public function expenseLivreur()
    {
        $user = auth('api')->user();
        $livreurExpenses = TeamExpense::with('category')
        ->with('boutique')
        ->with('user')
        ->with('provided')
        ->where('user_id',  $user->id)
        ->get();
        $livreur = Livreur::where('user_id', $user->id)->firstOrFail();        
        $societe = SocieteTransport::where('id', $livreur->societeTransport_id)->with('boutique')->firstOrFail();
        $boutique = $societe->boutique; 
        return response()->json(['livreurExpenses' => $livreurExpenses, 'boutique'=>$boutique, 'user'=>$user], 200);
    }
    public function sendMail(Request $request, $store)
    {   
        $commande_id = $request->input('order_id');
        $accepted = $request->input('accepted');
        $user = auth('api')->user();
        $boutique = Boutique::where('id', $store)->firstOrFail();
        $responsable_id = $boutique->user_id;
        $user = User::where('id', $responsable_id)->firstOrFail();
        $responsableEmail = $user->email;
        $subject = '';
        // Vérifier si le livreur a accepté ou refusé la commande
        if ($accepted === 0) {
            throw new \Exception("Commande en attente", 400);
        }
        $LivreurData = [
            'boutique' => $boutique->name,
            'accepted' => $accepted,
            'user' => $user->name,
            'subject' => $subject,
            'commande_id'=>$commande_id,
            'company' => 'GTEL'
        ];
        // Créer une instance de la classe LivreurConfirmationMail avec les paramètres nécessaires
        $email = new LivreurConfirmationMail($responsableEmail, $LivreurData);
        try {
            // Envoyer l'e-mail au responsable de la boutique
            Mail::send($email);
            return response()->json(['message' => 'E-mail envoyé avec succès au responsable de la boutique'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => "Erreur lors de l'envoi de l'e-mail", 'error' => $e->getMessage(),'trace' => $e->getTrace()], 400);
        }
   }
   public function sendNotification(Request $request, $store)
   {
       $user = auth('api')->user();
       $accepted = $request->input('accepted');
       $commande_id = $request->input('order_id');
       $livreur_id = $request->input('livreur_id');

       // Vérifiez si le livreur existe
       $livreur = Livreur::find($livreur_id);
       if (!$livreur) {
           return response()->json(['message' => 'Livreur introuvable'], 404);
       }
       $livreurCommande=LivreurCommandes::where('livreur_id', $livreur_id)
                       ->where('order_id', $commande_id)
                       ->firstOrFail();
       // Vérifiez si la boutique existe
       $boutique=Boutique::where('id', $store)->firstOrFail();
       if (!$boutique) {
           return response()->json(['message' => 'Boutique introuvable'], 404);
       }
       $notification = new LivreurCommandeStatusUpdated($livreurCommande, $boutique);

       try {
           // Envoyer l'événement et la notification à l'administrateur de la boutique
           Event::dispatch($notification);
           // Récupérez l'admin de la boutique associée au livreur
           $adminId = $boutique->user_id;
           if($accepted==1){
               // Enregistrez également la notification pour l'admin de la boutique dans la base de données
               $notificationMessageAdmin = 'La commande ' . $commande_id . ' a été accepter par le livreur ' . $user->name . '.';
               $notificationDataAdmin = ['user_id' => $adminId, 'message' => $notificationMessageAdmin];
               Notification::create($notificationDataAdmin);
           }
           if($accepted==-1){
                // Enregistrez également la notification pour l'admin de la boutique dans la base de données
               $notificationMessageAdmin = 'La commande ' . $commande_id . ' a été refuser par le livreur ' . $livreur_id . '.';
               $notificationDataAdmin = ['user_id' => $adminId, 'message' => $notificationMessageAdmin];
               Notification::create($notificationDataAdmin);
           }
           return response()->json(['message' => 'Notification envoyée avec succès'], 200);
       } catch (\Exception $e) {
           return response()->json(['message' => "Erreur lors de l'envoi de la notification", 'error' => $e->getMessage(), 'trace' => $e->getTrace()], 400);
       }
      
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

public function updateStatus(Request $request)
    {
        try {
            // Store data
            $boutique_id = $request->input('store');
            $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
            $order_id = $request->input('order_id');
            $commande = Commande::where('id', $order_id)->firstOrFail();
            $livreurCommande = LivreurCommandes::where('order_id', $order_id)
            ->where('accepted',1)
            ->firstOrFail();
            // Order data
            $status = $request->input('status');

            // Get current order data
            $commande->update([
                'status' => $status,
            ]);
          
            $enCoursStatus = StatutLivraison::where('status', 'En cours')->firstOrFail();
            $enCoursStatusId = $enCoursStatus->id;
    
            // Update the status in LivreurCommandes
            $livreurCommande->update([
                'statut_livraison_id' => $enCoursStatusId,
            ]);
            // Update the status in Commandes
            $commande->update([
                'statut_livraison_id' => $enCoursStatusId,
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Impossible de mettre à jour la commande : " . $exception->getMessage()
            ]);
        }
    }
    public function updateLivraisonStatut(Request $request, $orderId)
    {
        $commande = Commande::findOrFail($orderId);
         // Vérifier si le livreurCommande existe
         $livreurCommande= LivreurCommandes::where('order_id',$orderId)
         ->where('accepted',1)
         ->first();
         if (!$livreurCommande) {
            // Statut de livraison existe déjà pour la même boutique, retourner un message d'erreur
            return response()->json(['message' => "Cette commande n'a pas encore ete accepter par un livreur"], 423);
        }
        $statutLivraisonActuel = $livreurCommande->statutLivraison;
        
        // Vérifiez si le nouveau statut est valide en fonction des statuts disponibles dans la table statut_livraisons
        $nouveauStatutLivraisonId = $request->input('statut_livraison_id');
        $boutique_id = $request->input('store');
        $statutLivraison = StatutLivraison::find($nouveauStatutLivraisonId);
        if (!$statutLivraison) {
            return response()->json(['message' => 'Statut de livraison invalide'], 400);
        }

        // Vérifier si le statut de livraison a changé
        if ($statutLivraisonActuel->id !== $nouveauStatutLivraisonId) {
            // Récupérer le numéro de téléphone du client associé à cette commande
            $client = Client::find($commande->client_id);
            $numeroTelephone = $client->telephone;
            $nameClient = $client->nom;
            $villeClient = $client->ville;
            // Récupérer le texte du template associé au nouveau statut de livraison
            $messagerie = Messagerie::where('statut_livraison_id', $nouveauStatutLivraisonId)
             ->where('boutique_id', $boutique_id)
             ->where('status_messagerie', 'en cours')
             ->first();
            if ($messagerie) {
                $template = Template::find($messagerie->template_id);
                $templateTexte = $template->texte;

                $livreur = Livreur::find($livreurCommande->livreur_id);
                $livreurPhone= $livreur->telephone;
                $user = User::find($livreur->user_id);
                $livreurName= $user->name;
                // Remplacer les variables du template par leurs valeurs réelles
                $templateTexte = str_replace('{{nom_client}}', $nameClient, $templateTexte);
                $templateTexte = str_replace('{{ville_client}}', $villeClient, $templateTexte);
                $templateTexte = str_replace('{{numero_client}}', $numeroTelephone, $templateTexte);
                $templateTexte = str_replace('{{reference_commande}}', $commande->id, $templateTexte);
                $templateTexte = str_replace('{{prix_total_commande}}', $commande->total, $templateTexte);
                $templateTexte = str_replace('{{nom_livreur}}', $livreurName, $templateTexte);
                $templateTexte = str_replace('{{numero_livreur}}', $livreurPhone, $templateTexte);

                $apiMessagerie = ApiMessagerie::where('id',$messagerie->api_messagerie_id)
                                    ->first();
                if($apiMessagerie->api_name=='Vonage'|| 'vonage'){
                // Exemple de code (à adapter selon votre configuration) :
                    $apiKey = $apiMessagerie->api_key;
                    $apiSecret = $apiMessagerie->api_secret;
                    $from = $nameClient;
                    $to = $numeroTelephone;
                    $message = $templateTexte;

                    // Créer le client Vonage avec les informations d'authentification
                    $client = new VonageClient(new VonageCredentials($apiKey, $apiSecret));
                    
                    // Envoyer le SMS via l'API de Vonage
                    $response = $client->message()->send([
                        'to' => $to,
                        'from' => $from,
                        'text' => $message
                    ]);
                    $commande->statut_livraison_id = $nouveauStatutLivraisonId;
                    $livreurCommande->statut_livraison_id = $nouveauStatutLivraisonId;
                    $commande->save();
                    $livreurCommande->save();
                    // Pour l'exemple, je vais simplement retourner le texte du template pour l'afficher dans la vue
                    return response()->json(['templateTexte' => $templateTexte]);
                }
        }
            
        }
        $commande->statut_livraison_id = $nouveauStatutLivraisonId;
        $livreurCommande->statut_livraison_id = $nouveauStatutLivraisonId;
        $commande->save();
        $livreurCommande->save();
        // Si le statut de livraison n'a pas changé, retourner une réponse vide
        return response()->json(['message' => 'Statut mis à jour avec succès','livreurCommande'=>$livreurCommande]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
