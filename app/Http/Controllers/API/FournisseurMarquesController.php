<?php

namespace App\Http\Controllers\Api;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Models\FournisseurMarques;
use App\Http\Controllers\Controller;

class FournisseurMarquesController extends Controller
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
    public function index()
    {
        $fournisseurMarques = FournisseurMarques::with('fournisseur')->with('marque')->get();
        return response()->json(['data' => $fournisseurMarques], 200);
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
    public function store(Request $request, $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseurId = $fournisseur->id;
        
        $this->validate($request, [
            'fournisseur_id' => 'required|integer',
            'marque_id' => 'required|integer',
        ]);

        // Vérifier si la relation existe déjà
        $relationExiste = FournisseurMarques::where('fournisseur_id', $fournisseurId)
            ->where('marque_id', $request['marque_id'])
            ->exists();

        if ($relationExiste) {
            return response()->json(['message' => 'Cet fournisseur dispose déjà de cette marque'], 422);
        }

        return FournisseurMarques::create([
            'fournisseur_id' => $fournisseurId,
            'marque_id' => $request['marque_id'],
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
