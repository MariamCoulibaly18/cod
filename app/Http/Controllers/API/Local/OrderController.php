<?php

namespace App\Http\Controllers\API\Local;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Livreur;
use App\Models\Produit;
use App\Models\Boutique;
use App\Models\Commande;
use App\Models\Template;
use App\Models\Messagerie;
use Illuminate\Http\Request;
use App\Models\ApiMessagerie;
use App\Exports\CommandeExport;
use App\Models\CommandeProduit;
use App\Models\StatutLivraison;
use App\Models\LivreurCommandes;
use Illuminate\Support\Facades\DB;
use Vonage\Client as VonageClient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Providers\FacturePdfProvider;
use Vonage\Client\Credentials\Basic as VonageCredentials;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($store)
    {
    
       $boutique = Boutique::where('id', $store)->with('clients.commandes.produits')->with('clients.commandes.statutLivraison')->firstOrFail();
       $clients = $boutique->clients;
       //return response()->json($clients, 200);
       $orders = [];
       foreach ($clients as $client) {
            $ords = $client->commandes;
            foreach ($ords as $item) {
                $line_items = CommandeProduit::where('commande_id', $item->id)->with('produit')->get();
                $order = [
                    'id' => $item->id,
                    'billing'=>[
                        'first_name' => $client->prenom,
                        'last_name' => $client->nom,
                        'address_1' => $client->adresse,
                        'country' => $client->pays,
                        'phone' => $client->telephone,
                        'email' => $client->email,
                    ],
                    'line_items' => $line_items->map(function ($item) {
                        return [
                            'id' => $item->produit->id,
                            'name' => $item->produit->nom,
                            'quantity' => $item->quantite,
                            'price' => $item->prix,
                            'total' => $item->produit->prix * $item->quantite ,
                            // 'statut_livraison' => $item->statutLivraison->status, // Inclure le statut de livraison ici
                        ];
                    }),
                    'date_created' => $item->created_at,
                    'status' => $item->status,
                    'email' => $client->email,
                    'total' => $item->total,
                    'statut_livraison'=>$item->statutLivraison,
                ];
                array_push($orders, $order);
            }
        }

        return response()->json($orders, 200);
    }
    
    public function updateStatutLivraison(Request $request, $orderId)
    {
        $commande = Commande::findOrFail($orderId);
         // Vérifier si le livreurCommande existe
         $livreurCommande = LivreurCommandes::where('order_id',$commande->id)
         ->first();
         $livreurCmd= LivreurCommandes::where('order_id',$commande->id)
         ->where('accepted',1)
         ->first();
         if (!$livreurCommande) {
             // Statut de livraison existe déjà pour la même boutique, retourner un message d'erreur
             return response()->json(['message' => "Cette commande n'a pas de livreur assigner"], 422);
         }
         if (!$livreurCmd) {
            // Statut de livraison existe déjà pour la même boutique, retourner un message d'erreur
            return response()->json(['message' => "Cette commande n'a pas encore ete accepter par un livreur"], 423);
        }
        $statutLivraisonActuel = $commande->statutLivraison;
        
        // Vérifiez si le nouveau statut est valide en fonction des statuts disponibles dans la table statut_livraisons
        $nouveauStatutLivraisonId = $request->input('statut_livraison_id');
        $boutique_id = $request->input('store_id');
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
                    $livreurCmd->statut_livraison_id = $nouveauStatutLivraisonId;
                    $commande->save();
                    $livreurCmd->save();
                    // Pour l'exemple, je vais simplement retourner le texte du template pour l'afficher dans la vue
                    return response()->json(['templateTexte' => $templateTexte]);
                }
        }
            
        }
        $commande->statut_livraison_id = $nouveauStatutLivraisonId;
        $livreurCmd->statut_livraison_id = $nouveauStatutLivraisonId;
        $commande->save();
        $livreurCmd->save();
        // Si le statut de livraison n'a pas changé, retourner une réponse vide
        return response()->json(['message' => 'Statut mis à jour avec succès','commande'=>$commande],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validations
        $this->validate($request, [
            'client' => 'required|array',
            'store' => 'required|exists:boutiques,id',
            'products' => 'required|array',
            'status' => 'required|string|in:pending,processing,on-hold,completed,canceled,refunded',
            'total' => 'required|numeric',
        ]);
        
        //for each product, check if quantity is > 0
       try{
            DB::beginTransaction();
            $boutique = Boutique::where('id', $request->store)->with('clients')->firstOrFail();
            $client = $boutique->clients->where('id',  $request->client['id'])->firstOrFail();
            // create order
            $commande = Commande::create([
                'client_id' => $client->id,
                'total' => $request->total,
                'status' => $request->status,
            ]);
            // create line items
            foreach ($request->products as $item) {
                $product = Produit::where('id', $item['id'])->firstOrFail();
                $quantite = $product['quantite'] - CommandeProduit::where('produit_id',$item['id'])->sum('quantite');            

                if($quantite < $item['quantity']){
                    throw new \Exception('Quantité insuffisante pour le produit '.$product->nom);
                }

                CommandeProduit::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $item['id'],
                    'quantite' => $item['quantity'],
                    'prix' => $item['price'],
                ]);
            }
            $commandeProduits = CommandeProduit::where('commande_id', $commande->id)->with('produit')->get();
            $data = [
                'numero_commande' => 'BC' . uniqid(),
                'commande' => $commande,
                'total' => $commande->total,
                'commandeProduit' => $commandeProduits,
                'client' => $client,
                'produits' => $request->products,
                'date' => Carbon::parse($commande->created_at)->format('d/m/Y'),
                'boutique'=> $boutique->name,
                // Autres données nécessaires pour le bon de commande
            ];
            // dd('salut');
            $commande->update([
                'bon_de_commande' => $data['numero_commande'].'.pdf',
            ]);
            FacturePdfProvider::generateBonCommandePDF($data, 'bon_de_commande');
            // dd('test');
            DB::commit();
            // Appel de la fonction d'exportation
            return response()->json($commande, 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 403);            
        }
    }
//     public function exportBonDeCommande($commandeId)
// {
//     $commande = Commande::where('id', $commandeId)->first();
//     dd($commande);
//         $pdf = public_path('bon_de_commande/' . $commande->bon_de_commande);

//         return FacturePdfProvider::downloadBonCommande($pdf);
//         //return response()->download($pdf);
// }
public function exportBonDeCommande($store_id,$commande)
{
    
    $commande = Commande::where('id', $commande)->first();
    dd($commande);
        // $pdf = public_path('bon_de_commande/' . $commande->bon_de_commande);

        // return FacturePdfProvider::downloadBonCommande($pdf);
        //return response()->download($pdf);
}

    /**
     * export orders to excel
     */
    public function export($store)
    {
        $boutique = Boutique::where('id', $store)->with('clients.commandes.produits')->firstOrFail();
        $clients = $boutique->clients;
        //return response()->json($clients, 200);
        $orders = [];
        foreach ($clients as $client) {
            $ords = $client->commandes;
            foreach ($ords as $item) {
                $line_items = CommandeProduit::where('commande_id', $item->id)->with('produit')->get();
                $order = [
                    'Order ID' => $item->id,
                    'Client' => $client->prenom.' '.$client->nom,
                    'Email' => $client->email,
                    'Phone' => $client->telephone,
                    'Address' => $client->adresse,
                    'Country' => $client->pays,
                    'Products' => $line_items->map(function ($item) {
                        return [
                            'Product Name' => $item->produit->nom,
                            'Quantity' => $item->quantite,
                            'Price' => $item->prix,
                            'Total' => $item->produit->prix * $item->quantite ,
                        ];
                    })->toArray(),
                    'Date Created' => $item->created_at,
                    'Status' => $item->status,
                    'Total Amount' => $item->total,
                ];
                array_push($orders, $order);
            }
        }
        $file_name = 'orders_'.$boutique->name.'_'.date('Y-m-d_H-i-s').'.xlsx';

        return Excel::download(new CommandeExport($orders,$boutique->name,'/images/stores/'.$boutique->type['icon']), $file_name);
    }
    public function modificationEnMasse(Request $request)
    {   
        // Données reçues depuis Vue.js
        $orderIds = $request->input('ids'); // Tableau des IDs des produits sélectionnés
        foreach ($orderIds as $orderId)
         {
            $commande = Commande::where('id', $orderId)->firstOrFail();
            // update order
            $commande->update([
                'status' =>  $request['status'],
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Mise à jour en masse réussie pour les commandes sélectionnés.'
        ], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($store,$id)
    {
        //
        try{
            $commande = Commande::where('id', $id)
                                                ->with(['client' => function ($query) use($store) {
                                                    $query->where('boutique_id', $store)
                                                    ->select('id', 'prenom', 'nom', 'adresse', 'telephone', 'email');
                                                }])
                                                ->with(['produits' => function ($query) use ($id) {
                                                    $query->where('commande_id', $id)
                                                        ->select('produits.id', 'produits.nom', 'produits.prix')
                                                        ->withPivot('quantite', 'prix');
                                                }])
                                                ->with('statutLivraison')
                                                ->firstOrFail();
            // data transformation
            $commande = [
                'id' => $commande->id,
                'client'=>[
                    'id' => $commande->client->id,
                    'first_name' => $commande->client->prenom,
                    'last_name' => $commande->client->nom,
                    'adress' => $commande->client->adresse,
                    'phone' => $commande->client->telephone,
                    'email' => $commande->client->email,
                ],
                'products' => $commande->produits->map(function ($item) {
                    //problem here
                    return [
                        'id' => $item->id,
                        'name' => $item->nom,
                        'quantity' => $item->pivot['quantite'],
                        'price' => $item->pivot['prix'],
                    ];
                }),
                'status' => $commande->status,
                'total' => $commande->total,
                'statut_livraison'=> $commande->statutLivraison,
            ];

            return response()->json($commande, 200);

        }catch(\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
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
        //validations
        $this->validate($request, [
            'client' => 'required|array',
            'store' => 'required|exists:boutiques,id',
            'products' => 'required|array',
            'status' => 'required|string|in:pending,processing,on-hold,completed,canceled,refunded',
            'total' => 'required|numeric',
        ]);
        //
        try{

            DB::beginTransaction();
            $commande = Commande::where('id', $id)->firstOrFail();
            // update order
            $commande->update([
                'status' => $request->status,
                'total' => $request->total,
                'client_id' => $request->client['id'],
            ]);
            // delete line items
            CommandeProduit::where('commande_id', $commande->id)->delete();
            //update line items
            foreach ($request->products as $item) {
                $product = Produit::where('id', $item['id'])->firstOrFail();
                $quantite = $product['quantite'] - CommandeProduit::where('produit_id',$item['id'])->sum('quantite');            

                if($quantite < $item['quantity'])
                     throw new \Exception('Quantité insuffisante pour le produit '.$product->nom);

                CommandeProduit::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $item['id'],
                    'quantite' => $item['quantity'],
                    'prix' => $item['price'],
                ]);

                
            }


            DB::commit();
            return response()->json($commande, 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(), 403);
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function supprimerEnMasse(Request $request)
    {
        try {
            // Récupérer l'ID du produit à partir de l'URL
            $orderIds = $request->input('ids'); // Tableau des IDs des produits sélectionnés           
            foreach ($orderIds as $orderId) {
                $commande = Commande::where('id', $orderId)->firstOrFail();
                // Récupérez le nom du fichier PDF associé à la commande
                $pdfFileName = $commande->bon_de_commande;
                // Supprimez le fichier PDF du répertoire public
                $pdfFilePath = public_path('bon_de_commande/' . $pdfFileName);
                // Vérifiez si le fichier existe avant de tenter de le supprimer
                if (File::exists($pdfFilePath)) {
                    File::delete($pdfFilePath);
                }           
                 $commande->delete(); // Cela supprimera également tous les éléments de la commande
                 CommandeProduit::where('commande_id', $commande->id)->delete();
            }
            return response()->json($commande, 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }    
    }
    public function destroy($store, $id)
    {
        //
        try{
            DB::beginTransaction();
            $commande = Commande::where('id', $id)->firstOrFail();
            // Récupérez le nom du fichier PDF associé à la commande
            $pdfFileName = $commande->bon_de_commande;
            // Supprimez le fichier PDF du répertoire public
            $pdfFilePath = public_path('bon_de_commande/' . $pdfFileName);
            // Vérifiez si le fichier existe avant de tenter de le supprimer
            if (File::exists($pdfFilePath)) {
                File::delete($pdfFilePath);
            }           
             $commande->delete(); // Cela supprimera également tous les éléments de la commande
             CommandeProduit::where('commande_id', $commande->id)->delete();
            DB::commit();
            return response()->json($commande, 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }    
    }
}
