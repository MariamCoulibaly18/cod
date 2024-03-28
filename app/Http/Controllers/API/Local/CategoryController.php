<?php

namespace App\Http\Controllers\API\Local;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($store)
    {
        //get all categories of a the products in a store
        $boutique = Boutique::where('id',$store)->with('categories')->firstOrFail();
        // data transformation
        $categories = $boutique->categories->map(function ($item, $key) {
            return [
                'id' => $item['id'],
                'name' => $item['nom'],
            ];
        });
        return response()->json($categories,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //if categorie with that name already exists,just attach it to $request->store
        $categorie = Categorie::where('nom',$request->name)->first();
        //convert $request name to lowercase
        if(empty($categorie) ||  strtolower($categorie->nom) != strtolower($request->name)){
            $categorie = Categorie::create([
                'nom' => $request->name
            ]);
        }
        
        //sync the categorie to the store
        $boutique = Boutique::where('id',$request->store)->with('categories')->firstOrFail();
        $boutique->categories()->syncWithoutDetaching($categorie->id);//syncWithoutDetaching to avoid duplicate entries

        return response()->json(['id'=> $categorie->id,'name' => $categorie->nom],200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_id)
    {
        //
        $this->validate($request,[
            'name' => 'unique:categories,nom,'.$category_id
        ]);


        $categorie = Categorie::where('id',$category_id)->with('boutiques')->firstOrFail();
        if(($categorie->nom != $request->name) && ($categorie->boutiques->count() > 1))
            return $this->store($request);
        
        
        $categorie->update([
            'nom' => $request->name,
        ]);

        return response()->json(['id'=> $categorie->id,'name' => $categorie->nom],200);
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
            $categoryIds = $request->input('ids'); // Tableau des IDs des produits sélectionnés          
            $store = $request->input('store');          
            foreach ($categoryIds as $categoryId) {
                $categorie = Categorie::where('id',$categoryId)->firstOrFail();
                //detach the categorie from the store
                $boutique = Boutique::where('id',$store)->with('categories')->firstOrFail();
                $boutique->categories()->detach($categorie->id);
                $categorie->delete();
            }
            return response()->json($categoryIds, 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Categorie non trouvée'], 404);
        }    
    }
    public function destroy($store,$category_id)
    {
        //
        $categorie = Categorie::where('id',$category_id)->firstOrFail();
        //detach the categorie from the store
        $boutique = Boutique::where('id',$store)->with('categories')->firstOrFail();
        $boutique->categories()->detach($categorie->id);
        $categorie->delete();
        return response()->json(['message' => 'Category deleted successfully'],200);
    }
}
