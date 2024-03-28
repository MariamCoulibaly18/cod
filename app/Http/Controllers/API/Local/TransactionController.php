<?php

namespace App\Http\Controllers\API\Local;

use App\Models\Marque;
use App\Models\Produit;
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
    $transactions = Transaction::where('boutique_id', $store)
        ->with('fournisseur')
        ->with('marque')
        ->with('fournisseurMarques')
        ->with('boutique')
        ->get();
    foreach ($transactions as $transaction) {
        // Récupérer le nom du produit en utilisant l'id de la transaction
        // $produit = Produit::find($transaction->produit_id);
        // if ($produit) {
        //     $transaction->produit_name = $produit->nom;
        // } else {
        //     $deletedProduct= ProduitSupprime::where('produit_id',$transaction->produit_id)->firstOrFail();
        //     // Si le produit n'existe pas, utiliser le nom stocké précédemment
        //     if ($deletedProduct) {
        //         $transaction->produit_name = $deletedProduct->name;
        //     } else {
        //         $transaction->produit_name = "Produit non disponible";
        //     }
        // }
        // isFactured 
        $transaction->isFactured = true;
        $facture_indirect = FactureIndirect::where('facture_type_id', $transaction->id)->where('type', 'tr')->first();
        if (!$facture_indirect) {
            $transaction->isFactured = false;
        }
    }
    
    return response()->json(['transaction' => $transactions, 'boutique' => $boutique], 200);
}

    public function getBrand(Request $request)
    {
        $boutique_id = $request->input('store');
        $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
        

          // L'utilisateur sélectionne un produit
          $produitId = $request->input('produit_id');

        // Vérifier l'attribut "Brand" du produit sélectionné
        $selectedProduct = Produit::where('id',$produitId)->firstOrFail();
        
        // Récupérer la marque du produit
        $marqueId = $selectedProduct->marque_id;
        $marque = Marque::where('id', $marqueId)->firstOrFail();
        $nomMarque = $marque->name;
        return response()->json($nomMarque);

    }

    public function updateQuantite(Request $request)
    {
        try {
            // Store data
            $boutique_id = $request->input('store');
            $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
           
            $produitId = $request->input('produit_id');

            // Product data
            $newStockQuantity = $request->input('quantite');

            // Get current product data
            $product = Produit::where('id',$produitId)->firstOrFail();

            // Calculate new stock quantity
            $currentStockQuantity = $product->quantite ?? 0;
            $updatedStockQuantity = $currentStockQuantity + $newStockQuantity;

            // Update product
            $product->update([
                'quantite' => $updatedStockQuantity,
            ]);

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
