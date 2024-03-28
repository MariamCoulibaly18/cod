<?php

namespace App\Http\Controllers\Api\Local;

use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Marque;
use App\Models\Produit;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($store)
    {
        $boutique = Boutique::where('id', $store)->firstOrFail();
        $brands = Marque::all();
            return response()->json($brands);

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
        $this->validate($request,[
            'name'=>'required|string|max:191',
        ]);
        $marque= Marque::create([
            'name'=> $request['name'],
            'description'=> $request['description'],
        ],200);
        return response()->json($marque,200);
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
            'description'=>'string',
        ]);

        $marque = Marque::findOrFail($id);
        $marque->name = $request['name'];
        $marque->description = $request['description'];
        $marque->save();
        return response()->json(['message'=>'Marque Updated Successfully', 'marque'=>$marque],200) ;
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
            $brandIds = $request->input('ids'); // Tableau des IDs des produits sélectionnés   
            $store = $request->input('store');          
            foreach ($brandIds as $brandId) {
                $marque = Marque::findOrFail($brandId);
                // Vérifier si la relation existe déjà
                $relationExiste = Produit::where('marque_id', $brandId)
                ->exists();
        
                if ($relationExiste) {
                return response()->json(['message' => 'Cette marque ne peut être supprimée car' . "\n" . 'elle est affectée à un ou plusieurs produits'], 422);
            }
       
               $marque->delete();
            }
            return response()->json($brandIds, 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Marque non trouvée'], 404);
        }    
    }
    public function destroy($id,$brand_id)
    {
        // Récupérer l'ID de la marque à partir de l'URL
        $brandId = (int) $brand_id;
        $marque = Marque::findOrFail($brandId);
         // Vérifier si la relation existe déjà
         $relationExiste = Produit::where('marque_id', $brandId)
         ->exists();

     if ($relationExiste) {
        return response()->json(['message' => 'Cette marque ne peut être supprimée car' . "\n" . 'elle est affectée à un ou plusieurs produits'], 422);

     }

        $marque->delete();
        return response()->json(['message'=>'Boutique Deleted Successfully'],200) ;
    }
}
