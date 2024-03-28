<?php

namespace App\Http\Controllers\Api;
use App\Models\Livreur;
use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Models\LivreurCommandes;
use App\Models\SocieteTransport;
use App\Http\Controllers\Controller;

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
        $commandes = LivreurCommandes::where('livreur_id', $livreur->id)->get();
        // return response()->json(['commandes' => $commandes]);

        
        //Pour afficher details des commandes associes au livreur
        
        $societe = SocieteTransport::where('id', $livreur->societeTransport_id)->with('boutique')->firstOrFail();
        $boutique = $societe->boutique;
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ScreenLivreurController';
          return (new $controller)->index();
    
    }
    public function expenseLivreur()
    {
        $user = auth('api')->user();
        $livreur = Livreur::where('user_id', $user->id)->firstOrFail();
        $societe = SocieteTransport::where('id', $livreur->societeTransport_id)->with('boutique')->firstOrFail();
        $boutique = $societe->boutique;
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ScreenLivreurController';
          return (new $controller)->expenseLivreur();
    
    }
    public function sendMail(Request $request, $store)
    {
      
        $user = auth('api')->user();
        $boutique=Boutique::where('id', $store)->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ScreenLivreurController';
          return (new $controller)->sendMail($request,$store);

    }
    public function sendNotification(Request $request, $store)
    { 
        $boutique=Boutique::where('id', $store)->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ScreenLivreurController';
          return (new $controller)->sendNotification($request,$store);
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
        $livreurCommande = LivreurCommandes::where('order_id', $id)
            ->whereIn('accepted', [0, 1])
            ->orderBy('accepted', 'desc')
            ->firstOrFail();

        if ($livreurCommande->accepted == -1) {
            $livreurCommande = LivreurCommandes::where('order_id', $id)
                ->where('accepted', -1)
                ->firstOrFail();
        }

        // Mettre à jour la colonne 'accepted' de la commande avec la valeur envoyée dans la requête
        $livreurCommande->accepted = $request->input('accepted');
        $livreurCommande->save();

        return response()->json(['message' => 'Statut mis à jour avec succès','livreurCommande'=>$livreurCommande], 200);
    }

public function updateStatus(Request $request)
    {
        $boutique_id = $request->input('store');
        $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ScreenLivreurController';
        return (new $controller)->updateStatus($request);
    }
    public function updateLivraisonStatut(Request $request, $orderId)
    {
        $boutique_id = $request->input('store');
        $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ScreenLivreurController';
        return (new $controller)->updateLivraisonStatut($request, $orderId);
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
