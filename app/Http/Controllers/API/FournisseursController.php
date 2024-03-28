<?php

namespace App\Http\Controllers\Api;

use App\Models\Marque;
use App\Models\Boutique;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FournisseursController extends Controller
{

    /*
    *constructor
    */
    
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

        $fournisseurs = Fournisseur::where('boutique_id', $store)->with('type')->with('marques')->get();
        return response()->json(['data' => $fournisseurs], 200);
        

    }
    public function getMarques($id)
    {
        // Récupérer le fournisseur en fonction de son ID
        $fournisseur = Fournisseur::findOrFail($id);
        
        // Récupérer toutes les marques associées au fournisseur
        $marques = $fournisseur->marques()->get(['name']);
        
        // Retourner la liste des marques
        return response()->json($marques);
    }
    public function addMarque(Fournisseur $fournisseur)
    {
        $marqueId = request()->input('marqueId');
        $fournisseur->marques()->attach($marqueId);

        return response()->json(['message' => 'Marque ajoutée avec succès.']);
    }
    
    public function getType($id)
    {
        // Récupérer le fournisseur en fonction de son ID
        $fournisseur = Fournisseur::findOrFail($id);
        
        // Récupérer toutes les marques associées au fournisseur
        $types = $fournisseur->type()->get(['type']);
        
        // Retourner la liste des marques
        return response()->json($types);
    }
    
    
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $this->validate($request,[
            'name'=>'required|string|max:191',
            'adresse'=>'required|string|max:191',
            'telephone'=>'required|string|max:191',
            'type_id'=>'required|integer',
            

        ]);
        return Fournisseur::create([
            'name'=> $request['name'],
            'adresse'=> $request['adresse'],
            'telephone'=> $request['telephone'],
            'type_id'=> $request['type_id'],
            'boutique_id'=> $request['store_id'],

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
        $this->validate($request,[
            'name'=>'required|string|max:191',
            'adresse'=>'required|string|max:191',
            'telephone'=>'required|string|max:191',
            'type.id'=>'required|integer',

        ]);

        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->name = $request['name'];
        $fournisseur->adresse = $request['adresse'];
        $fournisseur->telephone = $request['telephone'];
        $fournisseur->type_id = $request['type.id'];
        $fournisseur->save();
        return ['message'=>'Fournisseur Updated Successfully', 'fournisseur'=>$fournisseur];
    
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
          $fournisseurs = Fournisseur::findOrFail($id);
          $fournisseurs->delete();
          return ['message'=>'Fournisseur Deleted Successfully'];
    }
    
}
