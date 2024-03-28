<?php

namespace App\Http\Controllers\API\Local;

use App\Models\Marque;
use App\Models\Produit;
use App\Models\Boutique;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\CommandeProduit;
use App\Models\ProduitSupprime;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($store)
    {
        //
        $boutique = Boutique::where('id', $store)->with('produits.categories', 'produits.marque')->firstOrFail();
        $produits = $boutique->produits;
        //data transformation
        $produits = $produits->map(function ($item, $key) {
            //calculate the available quantity of the product from commande table
            $quantite = $item['quantite'] - CommandeProduit::where('produit_id',$item['id'])->sum('quantite');            

            return [
                'id' => $item['id'],
                'name' => $item['nom'],
                'sku' => $item['sku'],
                'status' => $item['pub_status'],
                'stock_status' => $item['stock_status'],
                'description' => $item['description'],
                'price' => $item['prix'],
                'stock_quantity' => $item['quantite'],
                'available_quantity' => $quantite,
                'permalien' => $item['permalien'],
                'categories' => $item['categories']->map(function ($item, $key) {
                    return [
                        'id' => $item['id'],
                        'name' => $item['nom'],
                    ];
                }),
                'marques' => [
                    'id' => $item['marque']['id'],
                    'name' => $item['marque']['name'],
                    'description' => $item['marque']['description'],
                    'logo' => $item['marque']['logo'],
                ],
            ];
        });
        return response()->json($produits,200);
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
        try{
            $brand = $request->input('brand'); 
            $marque = Marque::where('name',$brand)->first();
            $brandId = $marque->id;
            DB::beginTransaction();

            $product = Produit::create([
                'nom' => $request->name,
                'sku' => $request->sku,
                'stock_status' => $request->stock_status,
                'pub_status' => $request->pub_status,
                'description' => $request->description,
                'prix' => $request->price,
                'quantite' => $request->stock_quantity,
                'permalien' => $request->slug,
                'boutique_id' => $request->store,
                'marque_id' => $brandId,
            ]);
            
            //
            /*if(!$request->categories){
                $product->categories()->attach(1);
            }*/
            $product->categories()->attach($request->categories);
            
            DB::commit();
            return response()->json(['message' => 'Product created successfully'],200);
        
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => 'Product creation failed','error' => $e],500);
        }     
    }

    /**
     * import products from csv file
     */
    public function import(Request $request){
        try{
            DB::beginTransaction();
            //get the data from csv file
            $data = $request->data;
            $boutique = Boutique::where('id',$request->store)->with('categories')->firstOrFail();

            if(!$data || count($data) == 0){
                return response()->json(['message' => 'No data found'],422);
            }

            foreach($data as $row){
                $errors = [];
                try{
                
                    //check if the product already exists
                    $product = Produit::where('sku',$row['sku'])->first();
                    if($product)
                        throw new \Exception('Product with '.$row['sku'].' already exists');

                    //create the product
                    $product = Produit::create([
                        'nom' => $row['nom'],
                        'sku' => $row['sku'],
                        'stock_status' => 'outofstock',
                        'pub_status' => $row['pub_status'],
                        'description' => $row['description'],
                        'prix' => $row['prix'],
                        'permalien' => $row['permalien'],
                        'boutique_id' => $request->store,
                    ]);
                    //search categories by name and attach them to the product
                    $categories = [];
                    foreach($row['categories'] as $category){
                        $cat = Categorie::where('nom',$category)->first();
                        if(!$cat){
                            $cat = Categorie::create([
                                'nom' => $category,
                            ]);
                            //attach it to boutique
                            //sync the categorie to the store
                            $boutique->categories()->syncWithoutDetaching($cat->id);//syncWithoutDetaching to avoid duplicate entries
                        }
        
                        $categories[] = $cat->id;
                    }
                    //attach the categories to the product
                    $product->categories()->attach($categories); 
                
                }catch(\Exception $e){
                    $errors[] = $e->getMessage();
                }
            }
            
            if(count($errors) > 0){
                DB::rollback();
                return response()->json(['message' => 'Products import failed','error' => $errors],422);
            }

            //commit the transaction
            DB::commit();
            return response()->json(['message' => 'Products imported successfully'],200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => 'Products import failed','error1' => $e],422);
        }
    }    
    public function getAttributes($store)
     {
         $boutique = Boutique::where('id', $store)->firstOrFail();
         $attributes = Marque::with('produits')->with('fournisseurs')->get();
    
             return response()->json($attributes);
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
    public function update(Request $request, $product_id)
    {
        //
        try{
            DB::beginTransaction();
            $product = Produit::where('id', $product_id)->with('categories', 'marque')->firstOrFail();
            $brandName = $request->input('brand');
            $marque = Marque::with('produits')->where('name',$brandName)->firstOrFail();
            $brandId= $marque->id;
            $product->update([
                'nom' => $request->name,
                'sku' => $request->sku,
                'stock_status' => $request->stock_status,
                'pub_status' => $request->pub_status,
                'description' => $request->description,
                'prix' => $request->price,
                'quantite' => $request->stock_quantity,
                'permalien' => $request->slug,
                'marque_id' => $brandId, // Mettre à jour la marque
            ]);
            
            //if categories doesn't changed
            if($product->categories->pluck('id') != $request->categories){
                //detach categories of the product 
                $product->categories()->detach();
                //attach new categories
                $product->categories()->attach($request->categories);
            }
            
            
            DB::commit();
            return response()->json(['message' => 'Product updated successfully'],200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => 'Product update failed','error' => $e],500);
        }    

    }
    public function modificationEnMasse(Request $request)
    {
        try {
            // Données reçues depuis Vue.js
            $productIds = $request->input('ids'); // Tableau des IDs des produits sélectionnés
            $categories = $request->input('categories'); // Tableau des nouvelles catégories
            $brandName = $request->input('marque'); // Nouvelle valeur de la marque
            foreach ($productIds as $productId) {
                $product = Produit::where('id', $productId)->with('categories', 'marque')->firstOrFail();
                $marque = Marque::with('produits')->where('name',$brandName)->firstOrFail();
                $brandId= $marque->id;
                $product->update([
                    'marque_id' => $brandId, 
                ]);
                 //if categories doesn't changed
                if($product->categories->pluck('id') != $request->categories){
                    //detach categories of the product 
                    $product->categories()->detach();
                    //attach new categories
                    $product->categories()->attach($request->categories);
                }
                
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Mise à jour en masse réussie pour les produits sélectionnés.'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Impossible de mettre à jour en masse : " . $exception->getMessage()
            ], 422);
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
            $productIds = $request->input('ids'); // Tableau des IDs des produits sélectionnés
            $boutique_id = $request->input('store');
            foreach ($productIds as $productId) {
                $product = Produit::where('id', $productId)->firstOrFail();
                $productData = [
                    'produit_id' => $product->id,
                    'name' => $product->nom,
                ];
                
                // Stocker le produit supprimé dans la table produit_supprimes
                ProduitSupprime::create($productData);
                
                // Détacher les catégories du produit et le supprimer
                $product->categories()->detach();
                $product->delete();
                
            }
    
            return response()->json([
                'success' => true,
                'message' => "Les produits #$productIds ont été supprimé avec succès."
            ]);
    
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Impossible de supprimer les produits : " . $exception->getMessage()
            ]);
        }
    }
    public function destroy($store, $product_id)
    {
        try {
            DB::beginTransaction();

            $product = Produit::where('id', $product_id)->firstOrFail();
            $productData = [
                'produit_id' => $product->id,
                'name' => $product->nom,
            ];
            
            // Stocker le produit supprimé dans la table produit_supprimes
            ProduitSupprime::create($productData);
            
            // Détacher les catégories du produit et le supprimer
            $product->categories()->detach();
            $product->delete();
            
            DB::commit();
            
            return response()->json(['message' => 'Produit supprimé avec succès'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Échec de la suppression du produit', 'error' => $e], 500);
        }
    }

}
