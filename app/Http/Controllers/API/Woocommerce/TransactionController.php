<?php

namespace App\Http\Controllers\API\WooCommerce;

use App\Models\Marque;
use App\Models\Boutique;
use App\Models\Fournisseur;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\FactureIndirect;
use App\Models\ProduitSupprime;
use App\Http\Controllers\Controller;
use App\Providers\WooCommerceService;

class TransactionController extends Controller
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
        $transactions = Transaction::where('boutique_id', $store)->with('fournisseur')->with('marque')->with('fournisseurMarques')->with('boutique')->get();
        //pour chaque transaction, on récupère le produit et on ajoute champ dans transaction 'produit_name'
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        foreach ($transactions as $transaction) {
            // Récupérer le nom du produit en utilisant l'id de la transaction
            // $produits = $woocommerce->get("products",['per_page' => 50]);
            // foreach ($produits as $produit) {
            //     if ($transaction->produit_id == $produit->id) {
            //         $transaction->produit_name = $produit->name;
            //         break; // Sortir de la boucle interne dès que le produit est trouvé
            //     }
            // }
            // if (!isset($transaction->produit_name)) {
            //     $deletedProduct = ProduitSupprime::where('produit_id', $transaction->produit_id)->first();
            //     if ($deletedProduct) {
            //         $transaction->produit_name = $deletedProduct->name;
            //     } else {
            //         $transaction->produit_name = "Produit non disponible";
            //     }
            // }
            //isFactured 
            $transaction->isFactured = true;
            $facture_indirect = FactureIndirect::where('facture_type_id', $transaction->id)->where('type','tr')->first();
            if(!$facture_indirect){
                $transaction->isFactured = false;
            }
        } 
        
        return response()->json(['transaction' => $transactions, 'boutique' => $boutique],200);
       
    }
    public function getBrand(Request $request)
    {
        $boutique_id = $request->input('store');
        $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
        
        // Récupérer le produit depuis WooCommerce
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        // $product = $woocommerce->get("products/{$produitId}");
        $products = $woocommerce->get('products');

          // L'utilisateur sélectionne un produit
          $produitId = $request->input('produit_id');

        // Vérifier l'attribut "Brand" du produit sélectionné
        $selectedProduct = $woocommerce->get("products/{$produitId}");
  
        if ($selectedProduct) {
            // Vérifier si l'attribut "Brand" existe pour le produit
            $brandTerms = null;
            foreach ($selectedProduct->attributes as $attribute) {
                if ($attribute->name == 'Brands') {
                    $brandTerms = $attribute->options;
                    break;
                }
            }
        // Retourner le terme de l'attribut "Brand" du produit
        if ($brandTerms) {
            $brandTerm = $brandTerms[0]; // Prendre le premier terme
            return response()->json($brandTerm);
        }
    }
    return response()->json(null);

    }
    public function updateQuantite(Request $request)
    {
        try {
            // Store data
            $boutique_id = $request->input('store');
            $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
            $storeUrl = $boutique->store_url;
            $consumerKey = $boutique->consumer_key;
            $consumerSecret = $boutique->consumer_secret;
            $woocommerce = WooCommerceService::getClient($storeUrl, $consumerKey, $consumerSecret);
            $produitId = $request->input('produit_id');

            // Product data
            $newStockQuantity = $request->input('quantite');

            // Get current product data
            $product = $woocommerce->get("products/$produitId");

            // Calculate new stock quantity
            $currentStockQuantity = $product->stock_quantity ?? 0;
            $updatedStockQuantity = $currentStockQuantity + $newStockQuantity;

            // Update product
            $productData = [
                'stock_quantity' => $updatedStockQuantity,
            ];

            $woocommerce->put("products/$produitId", $productData);

            return response()->json([
                'success' => true,
                'message' => "Le produit #$produitId a été mis à jour avec succès."
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Impossible de mettre à jour le produit : " . $exception->getMessage()
            ]);
        }
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
    public function show($store,$id)
    {
        //
        $boutique = Boutique::where('id', $store)->with('transactions')->firstOrFail();
        $transaction = $boutique->transactions()->where('id', $id)->firstOrFail();
        dd($transaction);
        //data transformation
        $transaction = [
            'id' => $transaction->id,
            'fournisseur' => Fournisseur::where('id', $transaction->fournisseur_id)->with('type')->firstOrFail(),
            'marque' => Marque::where('id', $transaction->marque_id)->firstOrFail(),
            'produit' => (new ProductController)->show($store,$transaction->produit_id),
            'quantite' => $transaction->quantite,
            'prix' => $transaction->prix,
            'total' => $transaction->total,
            'created_at' => $transaction->created_at->format('d/m/Y H:i:s'),
        ];

        return $transaction;

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
