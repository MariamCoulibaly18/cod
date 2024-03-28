<?php

namespace App\Http\Controllers\API\WooCommerce;

use App\Models\Boutique;
use App\Models\PointVente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\WooCommerceService;

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
        $boutique = Boutique::where('id', $store)->firstOrFail();
        $pointVentes = PointVente::with('boutique')->where('boutique_id', $store)->get();
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        $filteredOrders = [];
        $orders = $woocommerce->get('orders', ['per_page' => 5]);
    
        foreach ($orders as $order) {
            $status = $order->status;
    
            // Vérifier si le statut de commande est "completed"
            if ($status === 'completed') {
                $filteredOrders[] = $order;
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
        $pointVente = PointVente::findOrFail($id);
        $pointVente->delete();
        return ['message'=>'Point de vente Deleted Successfully'];
    }
}

