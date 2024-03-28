<?php

namespace App\Http\Controllers\Api\Woocommerce;
use stdClass;
use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\WooCommerceService;

class BrandController extends Controller
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
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
    
        // Récupérer les attributs des produits depuis WooCommerce
        $attributes = $woocommerce->get('products/attributes');
    
        // Chercher l'attribut 'pa_brand' qui représente les marques
        $brandAttribute = null;
        foreach ($attributes as $attribute) {
            if ($attribute->name === 'Brands') {
                $brandAttribute = $attribute;
                break;
            }
        }
        // Vérifier si l'attribut des marques existe
        if ($brandAttribute !== null) {
            // Récupérer les termes (valeurs) de l'attribut des marques
            $brands = $woocommerce->get("products/attributes/{$brandAttribute->id}/terms" , ['per_page'=> 100]);

        
            return response()->json($brands);
        }

        // Aucun attribut des marques trouvé
        return response()->json([]);
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
         
        $boutique_id = $request['store'];
        $boutique =Boutique::where('id', $boutique_id)->firstOrFail();

        // Récupérer les données du produit à partir de la requête
        $name = $request->input('name');
        $lien = $request->input('slug');
        $description = $request->input('description');

        // $description = $request->input('description');
        $storeUrl = $boutique->store_url;
        $consumerKey = $boutique->consumer_key;
        $consumerSecret = $boutique->consumer_secret;

        // Connexion à l'API WooCommerce
        $woocommerce = WooCommerceService::getClient($storeUrl, $consumerKey, $consumerSecret);
        // Récupérer les attributs des produits depuis WooCommerce
        $attributes = $woocommerce->get('products/attributes');

        // Chercher l'attribut 'Brands' qui représente les marques
        $brandAttribute = null;
        foreach ($attributes as $attribute) {
            if ($attribute->name === 'Brands') {
                $brandAttribute = $attribute;
                break;
            }
        }

        // Vérifier si l'attribut des marques existe
        if ($brandAttribute !== null) {
            // Créer un nouveau terme pour l'attribut 'Brands'
            $brandData = [
                'name' => $name,
                'description' => $description,
                'slug' => $lien,
            ];

        $response = $woocommerce->post("products/attributes/{$brandAttribute->id}/terms", $brandData);


        return response()->json($response);
    }
    // Aucun attribut des marques trouvé
    return response()->json(['message' => 'L\'attribut "Brands" n\'existe pas.']);
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
    // public function update(Request $request)
    // {
    //     $boutiqueId = $request->input('store');
    //     $termId = $request->input('term_id');
    //     $name = $request->input('name');
    //     $description = $request->input('description');
    
    //     $boutique = Boutique::where('id', $boutiqueId)->firstOrFail();
    //     $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
    
    //     // Récupérer les attributs des produits depuis WooCommerce
    //     $attributes = $woocommerce->get('products/attributes');
    
    //     // Chercher l'attribut 'Brands' qui représente les marques
    //     $brandAttribute = null;
    //     foreach ($attributes as $attribute) {
    //         if ($attribute->name === 'Brands') {
    //             $brandAttribute = $attribute;
    //             break;
    //         }
    //     }
    
    //     // Vérifier si l'attribut des marques existe
    //     if ($brandAttribute !== null) {
    //         // Récupérer le terme à mettre à jour
    //         $termToUpdate = $woocommerce->get("products/attributes/{$brandAttribute->id}/terms/{$termId}");
    
    //         // Vérifier si le terme existe
    //         if ($termToUpdate) {
    //             // Mettre à jour les propriétés du terme
    //             $termToUpdate->name = $name;
    //             $termToUpdate->description = $description;
    
    //             // Mettre à jour le terme dans WooCommerce
    //             $updatedTerm = $woocommerce->put("products/attributes/{$brandAttribute->id}/terms/{$termId}", $termToUpdate);
    
    //             return response()->json($updatedTerm);
    //         }
    
    //         // Le terme n'a pas été trouvé
    //         return response()->json(['message' => 'Le terme spécifié n\'existe pas.']);
    //     }
    
    //     // Aucun attribut des marques trouvé
    //     return response()->json(['message' => 'L\'attribut "Brands" n\'existe pas.']);
    // }
    
    public function update(Request $request, $brand_id)
    {
        // Récupérer les données du terme à partir de la requête
        $name = $request->input('name');
        $description = $request->input('description');
        $lien = $request->input('slug');

        // Récupérer l'ID de la boutique
        $boutique_id = $request->input('store');
        $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
    
        // Connexion à l'API WooCommerce
        $storeUrl = $boutique->store_url;
        $consumerKey = $boutique->consumer_key;
        $consumerSecret = $boutique->consumer_secret;
        $woocommerce = WooCommerceService::getClient($storeUrl, $consumerKey, $consumerSecret);
    
        // Récupérer les attributs des produits depuis WooCommerce
        $attributes = $woocommerce->get('products/attributes');
    
        // Chercher l'attribut 'Brands' qui représente les marques
        $brandAttribute = null;
        foreach ($attributes as $attribute) {
            if ($attribute->name === 'Brands') {
                $brandAttribute = $attribute;
                break;
            }
        }
    
        // Vérifier si l'attribut des marques existe
        if ($brandAttribute !== null) {
            // Mettre à jour le terme dans l'attribut 'Brands'
            $brandData = [
                'name' => $name,
                'description' => $description,
                'slug' => $lien,
            ];
    
            $response = $woocommerce->put("products/attributes/{$brandAttribute->id}/terms/{$brand_id}", $brandData);
    
            return response()->json($response);
        }
    
        // Aucun attribut des marques trouvé
        return response()->json(['message' => 'L\'attribut "Brands" n\'existe pas.']);
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
            $marqueIds = $request->input('ids'); // Tableau des IDs des marques sélectionnés
            $store = $request->input('store'); // Tableau des IDs des marques sélectionnés

            // Récupérer les informations de connexion à WooCommerce à partir de la base de données
            $boutique = Boutique::where('id', $store)->firstOrFail();
            // Connexion à l'API WooCommerce
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
            // Récupérer les attributs des produits depuis WooCommerce
            $attributes = $woocommerce->get('products/attributes');
        
            // Chercher l'attribut 'Brands' qui représente les marques
            $brandAttribute = null;
            foreach ($attributes as $attribute) {
                if ($attribute->name === 'Brands') {
                    $brandAttribute = $attribute;
                    break;
                }
            }
            if ($brandAttribute !== null) {
                foreach ($marqueIds as $marqueId) {
                    // Supprimer la marque
                    $woocommerce->delete("products/attributes/{$brandAttribute->id}/terms/{$marqueId}", ['force' => true]);
        
                }
            }
    
            return response()->json([
                'success' => true,
                'message' => "Les marques #$marqueIds ont été supprimé avec succès."
            ]);
    
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Impossible de supprimer les marques : " . $exception->getMessage()
            ]);
        }
    }
    public function destroy($store, $brand_id)
    {
         // Récupérer les informations de connexion à WooCommerce à partir de la base de données
         $boutique = Boutique::where('id', $store)->firstOrFail();
    
         // Récupérer l'ID de la marque à partir de l'URL
         $brandId = (int) $brand_id;
 
         // Connexion à l'API WooCommerce
         $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
         // Récupérer les attributs des produits depuis WooCommerce
        $attributes = $woocommerce->get('products/attributes');
    
        // Chercher l'attribut 'Brands' qui représente les marques
        $brandAttribute = null;
        foreach ($attributes as $attribute) {
            if ($attribute->name === 'Brands') {
                $brandAttribute = $attribute;
                break;
            }
        }
    
        // Vérifier si l'attribut des marques existe
        if ($brandAttribute !== null) {

             // Supprimer la marque
            $woocommerce->delete("products/attributes/{$brandAttribute->id}/terms/{$brandId}", ['force' => true]);
    
         return response()->json([
             'success' => true,
             'message' => "La marque #$brandId a été supprimé avec succès."
         ]);
    }
    return response()->json([
        'succes' => false,
        'message' => "La marque #$brandId n'existe pas."
    ]);
}
}