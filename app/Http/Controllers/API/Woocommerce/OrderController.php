<?php

namespace App\Http\Controllers\API\WooCommerce;

use App\Exports\CommandeExport;
use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\FactureIndirect;
use App\Models\LivreurCommandes;
use App\Providers\WooCommerceService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class OrderController extends Controller
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
        $boutique = Boutique::where('id', $store)->first();
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        $orders = $woocommerce->get('orders' , ['per_page' => 50]);
        //I want to add for each order un attribut 'isFactured' that is true if the order is factured and false if not
        foreach ($orders as $order) {
            $order->isFactured = true;
            $facture_indirect = FactureIndirect::where('facture_type_id', $order->id)->where('type','pr')->first();
            if(!$facture_indirect){
                $order->isFactured = false;
            }
        }
        return response()->json($orders, 200);
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
     * export orders to excel
     * 
     */

    public function export($store){
        $boutique = Boutique::where('id', $store)->first();
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        $orders = $woocommerce->get('orders');
        $data = [];
        foreach ($orders as $order) {
            $item = [
                'Order ID' => $order->id,
                'Client' => $order->billing->first_name . ' ' . $order->billing->last_name,
                'Email' => $order->billing->email,
                'Phone' => $order->billing->phone,
                'Address' => $order->billing->address_1 . ' ' . $order->billing->address_2,
                'Country' => $order->billing->country,
                'Products' => collect($order->line_items)->map(function ($item) {
                    return [
                        'Product Name' => $item->name,
                        'Quantity' => $item->quantity,
                        'Price' => $item->price,
                        'Total' => $item->total,
                    ];
                })->toArray(),
                'Date Created' => $order->date_created,
                'Status' => $order->status,
                'Total Amount' => $order->total,
            ];
            array_push($data, $item);
        }
        
        $file_name = 'orders_'.$boutique->name.'_'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new CommandeExport($data,$boutique->name,'/images/stores/'.$boutique->type['icon']), $file_name);
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
        $boutique = Boutique::where('id', $store)->first();
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        $order = $woocommerce->get('orders/' . $id);
        $order = json_decode(json_encode($order));
        // data transformation
        $order = [
            'id' => $order->id,
            'client'=>[
                'id' => $order->customer_id,
                'first_name' => $order->billing->first_name,
                'last_name' => $order->billing->last_name,
                'adress' => $order->billing->address_1 . ' ' . $order->billing->address_2,
                'phone' => $order->billing->phone,
                'email' => $order->billing->email,
                'country' => $order->billing->country,
            ],
            'products' => collect($order->line_items)->map(function ($item) {
                //problem here
                return [
                    'id' => $item->product_id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'sku' => $item->sku,
                ];
            }),
            'status' => $order->status,
            'total' => $order->total,
            'shipping_total' => $order->shipping_total,
            'shipping_tax' => $order->shipping_tax,
            // 'statut_livraison'=>$order->statutLivreur,
            'created_at' => $order->date_created,
        ];
        return response()->json($order, 200);
        // return $order;
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
        $boutique_id = $request['store'];
        $boutique = Boutique::where('id', $boutique_id)->first();

        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        $data = [
            'status' => $request['status']
        ];
        $woocommerce->put('orders/' . $id, $data);
        return response()->json(['message' => 'Order status updated successfully'], 200);
    }


    /**
     * Update multiple orders status
     * 
     */
    
    //  public function updateMultiple(Request $request, $orderId)
    // {
    
    //     $boutique_id = $request['store'];
    //     $orderIds = $request->input('order_ids');
    
    //     $boutique = Boutique::where('id', $boutique_id)->first();
    //     $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
    
    //     foreach ($orderIds as $orderId) {
    //         $data = [
    //             'status' => $request['status']
    //         ];
    //         $woocommerce->put('orders/' . $orderId, $data);
    //     }
    
    //     return response()->json(['message' => 'Orders status updated successfully'], 200);
    // }
    public function modificationEnMasse(Request $request)
    {
        
        // Données reçues depuis Vue.js
        $orderIds = $request->input('ids'); // Tableau des IDs des produits sélectionnés
        $boutique_id = $request['store'];
        $boutique = Boutique::where('id', $boutique_id)->first();
        $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
        foreach ($orderIds as $orderId) {
            $data = [
                'status' => $request['status']
            ];
            $woocommerce->put('orders/' . $orderId, $data);
        }
        return response()->json([
            'success' => true,
            'message' => 'Mise à jour en masse réussie pour les commandes sélectionnés.'
        ], 200);
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
            $orderIds = $request->input('ids'); // Tableau des IDs des produits sélectionnés
            $boutique_id = $request['store'];
            // Connexion à l'API WooCommerce
            $boutique = Boutique::where('id', $boutique_id)->first();
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);            
            foreach ($orderIds as $orderId) {
                // Supprimer la commande
                $woocommerce->delete('orders/' . $orderId, ['force' => true]);
            }
    
            return response()->json([
                'success' => true,
                'message' => "Les commandes #$orderIds ont été supprimé avec succès."
            ]);
    
        }catch(\Exception $e){
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }
    }
    public function destroy($store, $id)
    {
        //
        try{
            $boutique = Boutique::where('id', $store)->first();
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
            $woocommerce->delete('orders/' . $id, ['force' => true]);
            return response()->json(['message' => 'La commande a été supprimée avec succès'], 200);
            
        }catch(\Exception $e){
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }
    }
}
