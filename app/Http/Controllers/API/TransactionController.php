<?php

namespace App\Http\Controllers\Api;

use App\Models\Marque;
use App\Models\Boutique;
use App\Models\Fournisseur;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FactureIndirect;
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
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\TransactionController';
        return (new $controller)->index($store);       
    }

    public function getBrand(Request $request)
    {
        $boutique_id = $request->input('store');
        $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\TransactionController';
        return (new $controller)->getBrand($request);
  

    }
    public function updateQuantite(Request $request)
    {
        $boutique_id = $request->input('store');
        $boutique = Boutique::where('id', $boutique_id)->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\TransactionController';
        return (new $controller)->updateQuantite($request);
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
        $this->validate($request, [
            'fournisseur_id' => 'required|integer',
            'marque_id' => 'required|integer',
            'boutique_id' => 'required|integer',
            'produit_id' => 'required|integer',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
            'total' => 'required|numeric',
            'produit_name' => 'required',
        ]);
        $transaction= Transaction::create([
            'fournisseur_id'=> $request['fournisseur_id'],
            'marque_id'=> $request['marque_id'],
            'boutique_id'=> $request['boutique_id'],
            'produit_id'=> $request['produit_id'],
            'quantite'=> $request['quantite'],
            'prix'=> $request['prix'],
            'total'=> $request['total'],
            'produit_name'=> $request['produit_name'],
        ]);
        return response()->json($transaction,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($store,$id)
    // {
    //     //
    //     $boutique = Boutique::where('id', $store)->with('transactions')->firstOrFail();
    //     // dd($id);
    //     $transaction = $boutique->transactions()->where('id', $id)->firstOrFail();
    //     //data transformation
    //     $transaction = [
    //         'id' => $transaction->id,
    //         'fournisseur' => Fournisseur::where('id', $transaction->fournisseur_id)->with('type')->firstOrFail(),
    //         'marque' => Marque::where('id', $transaction->marque_id)->firstOrFail(),
    //         // 'produit' => (new ProductController)->show($store,$transaction->produit_id),
    //         'quantite' => $transaction->quantite,
    //         'prix' => $transaction->prix,
    //         'total' => $transaction->total,
    //         'created_at' => $transaction->created_at->format('d/m/Y H:i:s'),
    //     ];

    //     return $transaction;

    // }
    public function show($store, $id)
{
    // Chercher la boutique avec ses transactions
    $boutique = Boutique::where('id', $store)->with('transactions')->firstOrFail();

    // Si l'ID est fourni, commencer la recherche à partir de cet ID, sinon, à partir du début
    $transactions = $boutique->transactions->where('id', '>=', $id ?? 0);

    // Parcourir les transactions jusqu'à en trouver une valide ou jusqu'à la fin
    foreach ($transactions as $transaction) {
        // Réaliser la transformation des données pour la transaction
        $transformedTransaction = [
            'id' => $transaction->id,
            'fournisseur' => Fournisseur::where('id', $transaction->fournisseur_id)->with('type')->firstOrFail(),
            'marque' => Marque::where('id', $transaction->marque_id)->firstOrFail(),
            // 'produit' => (new ProductController)->show($store,$transaction->produit_id),
            'quantite' => $transaction->quantite,
            'prix' => $transaction->prix,
            'total' => $transaction->total,
            'is_visible'=>$transaction->visible,
            'produit_name'=> $transaction->produit_name,
            'created_at' => $transaction->created_at->format('d/m/Y H:i:s'),
        ];

        return $transformedTransaction;
    }

    // Si aucune transaction valide n'a été trouvée, vous pouvez retourner un message
    return ['message' =>" Aucune transaction valide n'a été trouvée"];
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
        $transaction = Transaction::findOrFail($id);
        $transaction->visible = $request['visible'];
        $transaction->save();
        return response()->json(['message'=>'Modification reussie'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $transactions = Transaction::findOrFail($id);
        // $transactions->delete();
        // return ['message'=>'transaction Deleted Successfully'];
    }
}
