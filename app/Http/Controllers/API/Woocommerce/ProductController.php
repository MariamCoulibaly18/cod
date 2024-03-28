<?php

namespace App\Http\Controllers\API\WooCommerce;

use GuzzleHttp\Client;
use App\Models\Boutique;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Utils;
use App\Models\ProduitSupprime;
use App\Http\Controllers\Controller;
use App\Providers\WooCommerceService;
use App\Http\Controllers\API\Woocommerce\CategoryController;

class ProductController extends Controller
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
        //return $store;
        $boutique = Boutique::where('id', $store)->firstOrFail();
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        //get just 10 products
        $products = $woocommerce->get('products', ['per_page'=> 100]);
        // $perPage = 10; // Vous pouvez ajuster ceci selon vos besoins
        // $offset = ($page - 1) * $perPage;
        // $products = $woocommerce->get('products', ['per_page' => $perPage, 'offset' => $offset]);
        //data transformation , à faire après !!! max priority
        $data = json_decode(json_encode($products), true);
        $data = collect($data)->map(function($item){
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'sku' => $item['sku'],
                'status' => $item['status'],
                'stock_status' => $item['stock_status'],
                'description' => $item['description'],
                'price' => $item['price'],
                'stock_quantity' => $item['stock_quantity'],
                'available_quantity' => 50,
                'permalien' => $item['permalink'],
                'categories' => collect($item['categories'])->map(function ($item, $key) {
                    return [
                        'id' => $item['id'],
                        'name' => $item['name'],
                    ];
                }),
                'attributes' => collect($item['attributes'])->map(function ($item, $key) {
                    return [
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'options' => $item['options'],
                    ];
                }),
            ];
        });


        return response()->json($data);
    }
    // public function index($store)
    // {
    //     // Récupération de la boutique
    //     $boutique = Boutique::where('id', $store)->firstOrFail();
    
    //     // Initialisation de WooCommerce
    //     $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
    
    //     // Paramètres de pagination
    //     $perPage = 20;
    //     $page = 1;
    
    //     // Récupération des produits par pagination
    //     $allProducts = collect();
    //     do {
    //         // Récupérer les produits de la page actuelle
    //         $products = $woocommerce->get('products', ['page' => $page, 'per_page' => $perPage]);
    
    //         // Vérifier si les produits sont vides ou non
    //         if (!is_array($products)) {
    //             break;
    //         }
    
    //         // Ajouter les produits récupérés à la liste complète
    //         $allProducts = $allProducts->merge($products);
    
    //         // Incrémenter le numéro de page pour la prochaine requête
    //         $page++;
    //     } while (!empty($products));
    
    //     // Transformation des données...
    //     $data = $allProducts->map(function ($item) {
    //         // Récupérer les informations du produit
    //         $id = $item->id;
    //         $name = $item->name;
    //         $sku = $item->sku;
    //         $status = $item->status;
    //         $stock_status = $item->stock_status;
    //         $description = $item->description;
    //         $price = $item->price;
    //         $stock_quantity = $item->stock_quantity;
    //         $permalink = $item->permalink;
    //         $categories = collect($item->categories)->map(function ($category) {
    //             return [
    //                 'id' => $category->id,
    //                 'name' => $category->name,
    //             ];
    //         });
    //         $attributes = collect($item->attributes)->map(function ($attribute) {
    //             return [
    //                 'id' => $attribute->id,
    //                 'name' => $attribute->name,
    //                 'options' => $attribute->options,
    //             ];
    //         });
    
    //         // Autres transformations si nécessaire...
    
    //         // Retourner les données du produit formatées
    //         return [
    //             'id' => $id,
    //             'name' => $name,
    //             'sku' => $sku,
    //             'status' => $status,
    //             'stock_status' => $stock_status,
    //             'description' => $description,
    //             'price' => $price,
    //             'stock_quantity' => $stock_quantity,
    //             'available_quantity' => 50, // Exemple de valeur statique pour "available_quantity"
    //             'permalien' => $permalink,
    //             'categories' => $categories,
    //             'attributes' => $attributes,
    //         ];
    //     });
    
    //     return response()->json($data);
    // }    
//     public function index($store)
// {
//     // Récupération de la boutique
//     $boutique = Boutique::where('id', $store)->firstOrFail();

//     // Initialisation de WooCommerce
//     $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);

//     // Paramètres de pagination
//     $perPage = 100;
//     $page = 1;

//     // Récupération des produits par pagination
//     $allProducts = collect();

//     do {
//         // Récupérer les produits de la page actuelle
//         $products = $woocommerce->get('products', ['page' => $page, 'per_page' => $perPage]);
    
//         // Vérifier si les produits sont vides ou non
//         if (!is_array($products)) {
//             break;
//         }
    
//         // Ajouter les produits récupérés à la liste complète
//         $allProducts = $allProducts->merge($products);
    
//         // Incrémenter le numéro de page pour la prochaine requête
//         $page++;
//     } while (!empty($products));

//      // Transformation des données...
//         $data = $allProducts->map(function ($item) {
//             // Récupérer les informations du produit
//             $id = $item->id;
//             $name = $item->name;
//             $sku = $item->sku;
//             $status = $item->status;
//             $stock_status = $item->stock_status;
//             $description = $item->description;
//             $price = $item->price;
//             $stock_quantity = $item->stock_quantity;
//             $permalink = $item->permalink;
//             $categories = collect($item->categories)->map(function ($category) {
//                 return [
//                     'id' => $category->id,
//                     'name' => $category->name,
//                 ];
//             });
//             $attributes = collect($item->attributes)->map(function ($attribute) {
//                 return [
//                     'id' => $attribute->id,
//                     'name' => $attribute->name,
//                     'options' => $attribute->options,
//                 ];
//             });

//             // Autres transformations si nécessaire...

//             // Retourner les données du produit formatées
//             return [
//                 'id' => $id,
//                 'name' => $name,
//                 'sku' => $sku,
//                 'status' => $status,
//                 'stock_status' => $stock_status,
//                 'description' => $description,
//                 'price' => $price,
//                 'stock_quantity' => $stock_quantity,
//                 'available_quantity' => 50, // Exemple de valeur statique pour "available_quantity"
//                 'permalien' => $permalink,
//                 'categories' => $categories,
//                 'attributes' => $attributes,
//             ];
//         });

//     return response()->json($data);
// }
// public function index($store, Request $request)
// {
//     // Récupération de la boutique
//     $boutique = Boutique::where('id', $store)->firstOrFail();

//     // Initialisation de WooCommerce
//     $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);

//     // Paramètres de pagination
//     $perPage = $request->input('per_page', 50); // Récupère la valeur 'per_page' de la requête, sinon utilise 50 par défaut
//     $page = $request->input('page', 1); // Récupère la valeur 'page' de la requête, sinon utilise 1 par défaut

//     // Récupération des produits par pagination
//     $allProducts = collect();
    
//     // Récupérer les produits de la page actuelle
//     $products = $woocommerce->get('products', ['page' => $page, 'per_page' => $perPage]);

//     // Vérifier si les produits sont vides ou non
//     if (is_array($products)) {
//         // Ajouter les produits récupérés à la liste complète
//         $allProducts = $allProducts->merge($products);
//     }

//     // Transformation des données...
//     $data = $allProducts->map(function ($item) {
//         // Récupérer les informations du produit
//         $id = $item->id;
//         $name = $item->name;
//         $sku = $item->sku;
//         $status = $item->status;
//         $stock_status = $item->stock_status;
//         $description = $item->description;
//         $price = $item->price;
//         $stock_quantity = $item->stock_quantity;
//         $permalink = $item->permalink;
//         $categories = collect($item->categories)->map(function ($category) {
//             return [
//                 'id' => $category->id,
//                 'name' => $category->name,
//             ];
//         });
//         $attributes = collect($item->attributes)->map(function ($attribute) {
//             return [
//                 'id' => $attribute->id,
//                 'name' => $attribute->name,
//                 'options' => $attribute->options,
//             ];
//         });

//         // Autres transformations si nécessaire...

//         // Retourner les données du produit formatées
//         return [
//             'id' => $id,
//             'name' => $name,
//             'sku' => $sku,
//             'status' => $status,
//             'stock_status' => $stock_status,
//             'description' => $description,
//             'price' => $price,
//             'stock_quantity' => $stock_quantity,
//             'available_quantity' => 50, // Exemple de valeur statique pour "available_quantity"
//             'permalien' => $permalink,
//             'categories' => $categories,
//             'attributes' => $attributes,
//         ];
//     });

//     return response()->json($data);
// }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        
        
        $boutique_id = $request['store'];
        $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
        // Récupérer les données du produit à partir de la requête
        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $sku = $request->input('sku');
        $stock_quantity = $request->input('stock_quantity');
        $stock_status = $request->input('stock_status'); 
        $pub_status = $request->input('pub_status');
        $lien = $request->input('slug');
        $category_ids = $request->input('categories');
        $brand = $request->input('brand'); 
        $storeUrl = $boutique->store_url;
        $consumerKey = $boutique->consumer_key;
        $consumerSecret = $boutique->consumer_secret;

        // Connexion à l'API WooCommerce
        $woocommerce = WooCommerceService::getClient($storeUrl, $consumerKey, $consumerSecret);
        // Récupérer l'ID de la catégorie sélectionnée
        //$category_ids = $request->input('category');

        // Créer le produit
        $productData = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'regular_price' => $price,
            'sku' => $sku,
            'stock_quantity' => $stock_quantity,
            'stock_status' => $stock_status,
            'status' => $pub_status,
            'slug' => $lien,
            'categories' => collect($category_ids)->map(function ($category_id) {
                return ['id' => $category_id];
            })->toArray(),
            'attributes' => [['name' => 'Brands', 'options' => [$brand]]],
            'store_url' => $storeUrl,
            'consumer_key' => $consumerKey,
            'consumer_secret' => $consumerSecret,
            'manage_stock' => true,
        ];
        // dd($productData);
        $response = $woocommerce->post('products', $productData);


        return response()->json($response);

    }
    public function productApi(Request $request)
    {
        $lien = file_get_contents($request->lien);

        // Traitez les données récupérées, par exemple en les convertissant en tableau JSON
        $lienArray = json_decode($lien, true);

        $produits = [];

        if (isset($lienArray['products'])) {
            $produits = $lienArray['products'];
        }
        $nombre=count($produits);
        if(count($produits) > 0){
        $errors = [];
        $boutique = Boutique::where('id',$request->store)->firstOrFail();
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        foreach($produits as $produit){
            try{
                 //return $categories_ids;
                 $product = [
                     'name' => $produit['title'],
                     'description' => $produit['description'],
                     'regular_price' => number_format($produit['price'], 2, '.', ''),
                     'stock_quantity' => $produit['stock'],
                     'attributes' => [['name' => 'Brands', 'options' => [$produit['brand']]]],
                     'manage_stock' => true,
                 ];
                 
                 $response = $woocommerce->post('products',$product);
                 //if response is not 201
                //  if($response->status != 201){
                //      throw new \Exception($response->message);
                //  }
                //  dd($product);

            }catch(\Exception $e){
                 $errors[] = $e->getMessage();
            }
         }
         return response()->json($response);
        //  if(count($errors) > 0){
        //     return response()->json(['errors' => $errors],422);
        // }
    }

    return response()->json(['Data is successfully added'],200);
    }
    
    /**
     * import excel file
     */

     public function import(Request $request){
        
        //$boutique = Boutique::where('id',$request->store)->firstOrFail();

        //insert data
        $data = $request->data;    
        //return $data;
        //length of data array must be > 0
        if(count($data) > 0){
            $errors = [];
            $boutique = Boutique::where('id',$request->store)->firstOrFail();
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
            //$categories = (new CategoryController)->index($request->store);
            //$categories = json_decode($categories->content(),true);
            foreach($data as $produit){
               try{
                    //search product by sku
                    $product_current = collect($woocommerce->get('products',['sku' => $produit['sku']]))->first();
                    //if product exist, we throw an exception
                    if($product_current != null)
                        throw new \Exception('Product with sku '.$produit['sku'].' already exist');

                    $categories_ids = collect($produit['categories'])->map(function ($category) use ($woocommerce) {
                        //return ['id' => $category['id'],'name' => $category['name']];
                        //search par nom
                        $cat_current = collect($woocommerce->get('products/categories',['search' => $category]))->first();
                        
                        //si la catégorie n'existe pas, on la crée
                        if($cat_current == null){
                            $cat = [
                                'name' => $category,
                            ];
                            $cat_current = $woocommerce->post('products/categories',$cat);
                        }
                        $cat_current = json_decode(json_encode($cat_current),true);

                        return ['id' => $cat_current['id']];
                    })->toArray();

                    //return $categories_ids;
                    $product = [
                        'name' => $produit['nom'],
                        'description' => $produit['description'],
                        'regular_price' => strval($produit['prix']),
                        'sku' => $produit['sku'],
                        'status' => $produit['pub_status'],
                        'stock_status' => 'outofstock',
                        'stock_quantity' => '0',
                        'slug' => $produit['permalien'],
                        'categories' => $categories_ids,
                        'attributes' => [['name' => 'Brands', 'options' => [$produit['marque']]]],
                        'manage_stock' => true,
                    ];
                    
                    $response = $woocommerce->post('products',$product);
                    //if response is not 201
                    /*if($response->status != 201){
                        throw new \Exception($response->message);
                    }*/
               }catch(\Exception $e){
                    $errors[] = $e->getMessage();
               }
            }
            if(count($errors) > 0){
                 return response()->json(['errors' => $errors],422);
            }
            return response()->json(['success'=>'Data is successfully added'],200);
        }
        return response()->json(['error'=>'Data is empty'],422);
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
        $boutique = Boutique::where('id', $store)->firstOrFail();
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        $product = $woocommerce->get('products/'.$id);

        //data transformation
        $product = json_decode(json_encode($product),true);
        $product = [
            'id' => $product['id'],
            'name' => $product['name'],
            'quantity'=> $product['stock_quantity'],
            'price' => $product['price'],
        ];

        return $product;
    }

    /**
     * get attributes of a product
     */

    public function getAttributes($store)
     {
         $boutique = Boutique::where('id', $store)->firstOrFail();
         $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
    
         // Récupérer les attributs des produits depuis WooCommerce
         $attributes = $woocommerce->get('products/attributes');
             return response()->json($attributes);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$product_id){
        
        try{
            //store data
            $boutique_id = $request->input('store');
            $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
            $storeUrl = $boutique->store_url;
            $consumerKey = $boutique->consumer_key;
            $consumerSecret = $boutique->consumer_secret;
            $woocommerce = WooCommerceService::getClient($storeUrl, $consumerKey, $consumerSecret);

            //product data
            $name = $request->input('name');
            $description = $request->input('description');
            $price = $request->input('price');
            $sku = $request->input('sku');
            $stock_quantity = $request->input('stock_quantity');
            $stock_status = $request->input('stock_status'); 
            $lien = $request->input('slug');
            $category_ids = $request->input('categories');
            //get attributes of product
            $brand = $request->input('brand');
            //update product
            $productData = [
                'name' => $name,
                'description' => $description,
                'regular_price' => $price,
                'sku' => $sku,
                'stock_quantity' => $stock_quantity,
                'stock_status' => $stock_status,
                'slug' => $lien,
                'categories' => collect($category_ids)->map(function ($category_id) {
                    return ['id' => $category_id];
                })->toArray(),
                'manage_stock' => true,
            ];
            $product = json_decode(json_encode($woocommerce->get('products/' . $product_id)),true);
            $attributes = $product['attributes'];
            //changer attribute Brands
            $isThereBrand = false;
            foreach($attributes as $attribute){
                if($attribute['name'] == 'Brands'){
                    $attribute['options'] = [$brand];
                    $productData['attributes'] = [$attribute];
                    $isThereBrand = true;
                    break;
                }
            }
            if(!$isThereBrand)
                $productData['attributes'] = [['name' => 'Brands','options' => [$brand]]];

            $response = $woocommerce->put("products/$product_id", $productData);

            /*if($response->status != 200){
                throw new \Exception($response->message);
            }*/

            return response()->json([
                'success' => true,
                'message' => "Le produit #$product_id a été mis à jour avec succès."
            ]);


        }catch(\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => "Impossible de mettre à jour le produit : " . $exception->getMessage()
            ],422);
        }
        

    }
    public function modificationEnMasse(Request $request)
    {
        try {

            $boutique_id = $request->input('store');
            $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
            $storeUrl = $boutique->store_url;
            $consumerKey = $boutique->consumer_key;
            $consumerSecret = $boutique->consumer_secret;
            $woocommerce = WooCommerceService::getClient($storeUrl, $consumerKey, $consumerSecret);
    
            // Données reçues depuis Vue.js
            $productIds = $request->input('ids'); // Tableau des IDs des produits sélectionnés
            $categories = $request->input('categories'); // Tableau des nouvelles catégories
            $marque = $request->input('marque'); // Nouvelle valeur de la marque
            foreach ($productIds as $productId) {
                $productData = [];
                // Vérifier s'il y a une valeur de catégorie à mettre à jour
                if (!empty($categories)) {
                    $productData['categories'] = collect($categories)->map(function ($category_id) {
                        return ['id' => $category_id];
                    })->toArray();
                }
                // Vérifier s'il y a une valeur de marque à mettre à jour
                if (!empty($marque)) {
                    $productData['attributes'] = [
                        [
                            'name' => 'Brands',
                            'options' => [$marque],
                        ],
                    ];
                }
                // Vérifier si des données sont à mettre à jour avant d'appeler l'API WooCommerce
                if (!empty($productData)) {
                    // Mettre à jour chaque produit individuellement s'il y a des données à mettre à jour
                    $response = $woocommerce->put("products/$productId", $productData);
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
            $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
            $storeUrl = $boutique->store_url;
            $consumerKey = $boutique->consumer_key;
            $consumerSecret = $boutique->consumer_secret;
            // Connexion à l'API WooCommerce
            $woocommerce = WooCommerceService::getClient($storeUrl, $consumerKey, $consumerSecret);
            foreach ($productIds as $productId) {
                // Récupérer les détails du produit avant de le supprimer
                $productDetails = $woocommerce->get("products/$productId");
                // Supprimer le produit
                $woocommerce->delete("products/$productId", ['force' => true]);  
                // Stocker le produit supprimé dans la table produit_supprimes
                ProduitSupprime::create([
                    'produit_id' => $productId,
                    'name' => $productDetails->name,
                ]); 
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
    public function destroy($store,$product_id)
    {
        try {
            // Récupérer les informations de connexion à WooCommerce à partir de la base de données
            $boutique = Boutique::where('id', $store)->firstOrFail();
    
            // Récupérer l'ID du produit à partir de l'URL
            $productId = (int) $product_id;
    
            // Connexion à l'API WooCommerce
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
            // Récupérer les détails du produit avant de le supprimer
            $productDetails = $woocommerce->get("products/$productId");

            // Supprimer le produit
            $woocommerce->delete("products/$productId", ['force' => true]);

            // Stocker le produit supprimé dans la table produit_supprimes
            ProduitSupprime::create([
                'produit_id' => $productId,
                'name' => $productDetails->name,
            ]);    
    
            return response()->json([
                'success' => true,
                'message' => "Le produit #$productId a été supprimé avec succès."
            ]);
    
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Impossible de supprimer le produit : " . $exception->getMessage()
            ]);
        }
    }
    
}
