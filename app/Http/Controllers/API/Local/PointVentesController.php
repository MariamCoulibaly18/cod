<?php

namespace App\Http\Controllers\Api\Local;

use App\Models\Boutique;
use App\Models\Commande;
use App\Models\PointVente;
use Illuminate\Http\Request;
use App\Models\CommandeProduit;
use App\Http\Controllers\Controller;



class PointVentesController extends Controller
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
        $pointVentes = PointVente::with('boutique')->where('boutique_id', $store)->get();
        $boutique = Boutique::where('id', $store)->with('clients.commandes.produits')->firstOrFail();
        $clients = $boutique->clients;
        $filteredOrders = [];
    
        foreach ($clients as $client) {
            $orders = $client->commandes->where('status', 'completed');
            
            foreach ($orders as $order) {
                $lineItems = CommandeProduit::where('commande_id', $order->id)->with('produit')->get();
                
                $filteredOrder = [
                    'id' => $order->id,
                    'billing' => [
                        'first_name' => $client->prenom,
                        'last_name' => $client->nom,
                        'address_1' => $client->adresse,
                        'country' => $client->pays,
                        'phone' => $client->telephone,
                        'email' => $client->email,
                        'state' => $client->ville,

                    ],
                    'line_items' => $lineItems->map(function ($item) {
                        return [
                            'id' => $item->produit->id,
                            'name' => $item->produit->nom,
                            'quantity' => $item->quantite,
                            'price' => $item->prix,
                            'total' => $item->produit->prix * $item->quantite,
                        ];
                    }),
                    'date_created' => $order->created_at,
                    'status' => $order->status,
                    'payment_method_title' => $client->type_payement,
                    'customer_id' => $order->client_id,
                    'email' => $client->email,
                    'total' => $order->total,
                ];
                
                array_push($filteredOrders, $filteredOrder);
            }
        }    
        return response()->json(['boutique' => $boutique, 'pointVentes' => $pointVentes, 'customers' => $filteredOrders], 200);
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
        $client = $request['client'];
        $telephone = $request['telephone'];
        $ville = $request['ville'];
        $type_payement = $request['type_payement'];
        $type_echange_commercial = $request['type_echange_commercial'];
        $order_id = $request['order_id']; 
        $boutique_id = $request['boutique_id'];
        $customer_id = $request['customer_id'];

    
            return PointVente::create([
                'client' => $client,
                'telephone' => $telephone,
                'ville' => $ville,
                'type_payement' => $type_payement,
                'order_id' => $order_id,
                'boutique_id' => $boutique_id,
                'type_echange_commercial' => $type_echange_commercial,
                'customer_id' => $customer_id,
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
