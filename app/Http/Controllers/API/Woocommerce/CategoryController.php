<?php

namespace App\Http\Controllers\API\Woocommerce;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Providers\WooCommerceService;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        //
        $booutique = Boutique::where('id', $store)->firstOrFail();
        // Connexion à l'API WooCommerce
        $woocommerceClient = WooCommerceService::getClient($booutique->store_url, $booutique->consumer_key, $booutique->consumer_secret);
        $category = $woocommerceClient->get('products/categories', ['per_page'=>100]);
        return response()->json($category);
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
            $name = $request->input('name');
            $description = $request->input('description');
            $lien = $request->input('slug');
            $categorieParentId = $request->input('categorieParentId'); 
            $boutique = Boutique::where('id',$request->store)->firstOrFail();
            // Connexion à l'API WooCommerce
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);

            $data = [
                'name' => $name,
                'description' => $description,
                'slug' => $lien,
                'parent' => $categorieParentId,
            ];
            $category = $woocommerce->post('products/categories', $data);
            return response()->json($category);

        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()], 500);
        }
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
        try{
            $boutique = Boutique::where('id',$request->store)->firstOrFail();
            $name = $request->input('name');
            $description = $request->input('description');
            $lien = $request->input('slug');
            $categorieParentId = $request->input('categorieParentId'); 
            // Connexion à l'API WooCommerce
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);

            $data = [
                'name' => $request->name,
                'description' => $description,
                'slug' => $lien,
                'parent' => $categorieParentId,
            ];
            $category = $woocommerce->put('products/categories/'.$category_id, $data);
            return response()->json($category);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()], 500);
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
            $categorieIds = $request->input('ids'); // Tableau des IDs des categories sélectionnés
            $store = $request->input('store'); // Tableau des IDs des categories sélectionnés
            $boutique = Boutique::where('id',$store)->firstOrFail();
            // Connexion à l'API WooCommerce
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
            foreach ($categorieIds as $categorieId) {
                // Supprimer le produit
                $woocommerce->delete('products/categories/'.$categorieId, ['force' => true]);
            }
    
            return response()->json([
                'success' => true,
                'message' => "Les categories #$categorieIds ont été supprimé avec succès."
            ]);
    
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Impossible de supprimer les categories : " . $exception->getMessage()
            ]);
        }
    }
    public function destroy($store, $category_id)
    {
        //
        try{
            $boutique = Boutique::where('id',$store)->firstOrFail();
            // Connexion à l'API WooCommerce
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
            $category = $woocommerce->delete('products/categories/'.$category_id, ['force' => true]);
            return response()->json($category);

        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()], 500);
        }    
    }
}
