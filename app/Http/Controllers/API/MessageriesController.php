<?php

namespace App\Http\Controllers\Api;

use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Messagerie;

class MessageriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index($store)
    {
        $boutique = Boutique::where('id', $store)->firstOrFail();
        $messageries = Messagerie::where('boutique_id', $store)->with('template')->with('apiMessagerie')->with('statutLivraison')->with('boutique')->get();
        return response()->json(['messageries' => $messageries, 'boutique' => $boutique],200);
       
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
        $this->validate($request, [
            'boutique_id' => '',
            'api_messagerie_id' => '',
            'statut_livraison_id' => '',
            'template_id' => '',
            'status_messagerie' => 'required|string',
            'recepteur' => 'required|string',
            'titre' => 'required|string|max:191',
        ]);
         // Vérifier si le statut de livraison existe déjà pour la même boutique
         $existingMessagerie = Messagerie::where('boutique_id', $request['boutique_id'])
         ->where('statut_livraison_id', $request['statut_livraison_id'])
         ->first();

        if ($existingMessagerie) {
        // Statut de livraison existe déjà pour la même boutique, retourner un message d'erreur
        return response()->json(['message' => 'Statut de livraison existe déjà pour la même boutique'], 422);
    }
        return Messagerie::create([
            'boutique_id'=> $request['boutique_id'],
            'api_messagerie_id'=> $request['api_messagerie_id'],
            'statut_livraison_id'=> $request['statut_livraison_id'],
            'template_id'=> $request['template_id'],
            'status_messagerie'=> $request['status_messagerie'],
            'recepteur'=> $request['recepteur'],
            'titre'=> $request['titre'],
        ]);
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
        $this->validate($request,[
            'boutique_id' => '',
            'api_messagerie_id' => '',
            'statut_livraison_id' => '',
            'template_id' => '',
            'status_messagerie' => 'string',
            'recepteur' => 'string',
            'titre' => 'string|max:191',
        ]);
        // Vérifier si le statut de livraison existe déjà pour la même boutique
        $existingMessagerie = Messagerie::where('boutique_id', $request['boutique_id'])
        ->where('statut_livraison_id', $request['statut_livraison_id'])
        ->first();

        if ($existingMessagerie) {
        // Statut de livraison existe déjà pour la même boutique, retourner un message d'erreur
        return response()->json(['message' => 'Statut de livraison existe déjà pour la même boutique'], 421);
        }
        $messagerie = Messagerie::findOrFail($id);
        $messagerie->boutique_id = $request['boutique_id'];
        $messagerie->api_messagerie_id = $request['api_messagerie_id'];
        $messagerie->statut_livraison_id = $request['statut_livraison_id'];
        $messagerie->template_id = $request['template_id'];
        $messagerie->status_messagerie = $request['status_messagerie'];
        $messagerie->recepteur = $request['recepteur'];
        $messagerie->titre = $request['titre'];
        $messagerie->save();
        return ['message'=>'Messagerie mise à jour avec succès', 'messagerie'=>$messagerie];
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
        $messagerie = Messagerie::findOrFail($id);
        $messagerie->delete();
        return ['message'=>'Messagerie supprimée avec succès'];
    }
}
