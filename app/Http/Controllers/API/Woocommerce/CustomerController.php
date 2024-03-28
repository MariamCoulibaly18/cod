<?php

namespace App\Http\Controllers\API\WooCommerce;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Providers\WooCommerceService;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
        try {
            $boutique = Boutique::where('id', $store)->firstOrFail();
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
            $customers = $woocommerce->get('customers', ['per_page' => 100]);

            foreach ($customers as $customer) {
                // Vérifie si le champ 'username' existe
                $username = isset($customer->username) ? $customer->username : null;

                // Si le champ 'username' existe, utilisez-le comme prénom
                $billingFirstName = $username ?? $customer->billing->first_name;
                $billingLastName = $customer->billing->last_name;

                $customerOrders = $woocommerce->get('orders', ['customer' => $customer->id]);

                $cancelledOrdersCount = 0;

                foreach ($customerOrders as $order) {
                    if ($order->status === 'cancelled') {
                        $cancelledOrdersCount++;
                    }
                }
                $customer->isBlacklisted = false;
                if ($cancelledOrdersCount >= 3) {
                    $customer->isBlacklisted = true;
                }

                // Met à jour les valeurs dans l'objet customer
                $customer->billing->first_name = $billingFirstName;
                $customer->billing->last_name = $billingLastName;
            }
            return response()->json($customers, 200);
        } catch(\Exception $e) {
            return response()->json(['message' => 'Boutique not found!','erreur'=>$e->getMessage()], 404);
        }
    }

    // public function index($store)
    // {
    //     try {
    //         $boutique = Boutique::where('id', $store)->firstOrFail();
    //         $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
    //         $customers = $woocommerce->get('customers', ['per_page' => 100]);
            
            
            
    //         foreach ($customers as $customer) {
    //             $customerOrders = $woocommerce->get('orders', ['customer' => $customer->id]);
                
    //             $cancelledOrdersCount = 0;
                
    //             foreach ($customerOrders as $order) {
    //                 if ($order->status === 'cancelled') {
    //                     $cancelledOrdersCount++;
    //                 }
    //             }
    //             $customer->isBlacklisted = false;
    //             if ($cancelledOrdersCount >= 3) {
    //                 $customer->isBlacklisted = true;
    //             }
    //         }
    //         return response()->json($customers, 200);
    //     } catch(\Exception $e) {
    //         return response()->json(['message' => 'Boutique not found!','erreur'=>$e->getMessage()], 404);
    //     }
    // }

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
            $boutique = Boutique::where('id', $request->store)->firstOrFail();
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
            $data = [
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'billing' => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address_1' => $request->adresse,
                    'country' => $request->country,
                    'email' => $request->email,
                    'phone' => $request->telephone
                ],
                'password' => $request->motdepasse,
                // 'password' => '123456789', 
            ];
            //problem is here
            $woocommerce->post('customers', $data); 
            return response()->json(['message' => 'Customer created successfully!'], 200);
            
        }catch(\Exception $e){
            return response()->json(['message' => 'Boutique not found!'], 405);
        }
    }

    /**
     * import excel file
     */

     public function import(Request $request){
        
        //$boutique = Boutique::where('id',$request->store)->firstOrFail();

        //insert data
        $data = $request->data;    
        //length of data array must be > 0
        if(count($data) > 0){
            $errors = [];
            $boutique = Boutique::where('id',$request->store)->firstOrFail();
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);

            foreach($data as $row){
               try{
                    $customer = [
                        'email' => $row['email'],
                        'first_name' => $row['prenom'],
                        'last_name' => $row['nom'],
                        'billing' => [
                            'first_name' => $row['prenom'],
                            'last_name' => $row['nom'],
                            'address_1' => $row['adresse'],
                            'country' => $row['pays'],
                            'email' => $row['email'],
                            'phone' => $row['telephone']
                        ],
                    ];
                    //send request to woocommerce rest api
                    $response = $woocommerce->post('customers', $customer);
                    //if response is not 201
                    /*if($response->status != 201){
                        throw new \Exception($response->message);
                    }*/
               }catch(\Exception $e){
                    $errors[] = $e->getMessage();
               }
            }
            if(count($errors) > 0){
                 return response()->json(['errors' => $errors],200);
            }
            return response()->json(['success'=>'Data is successfully added'],200);
        }
        return response()->json(['error'=>'Data is empty'],200);
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
    public function update(Request $request, $costumer_id)
    {
        //
        try{
            $boutique = Boutique::where('id', $request->store)->firstOrFail();
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
            $data = [
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'billing' => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address_1' => $request->adresse,
                    'country' => $request->country,
                    'email' => $request->email,
                    'phone' => $request->telephone
                ],
            ];
            //problem is here
            $woocommerce->put('customers/'.$costumer_id, $data);   
            return response()->json(['message' => 'Customer updated successfully!'], 200);

        }catch(\Exception $e){
            return response()->json(['message' => 'Boutique not found!'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($store,$costumer_id)
    {
        //
        try{
            
            $boutique = Boutique::where('id', $store)->firstOrFail();
            $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
            $woocommerce->delete('customers/'.$costumer_id, ['force' => true]);
            
            return response()->json(['message' => 'Customer deleted successfully!'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Boutique not found!'], 404);
        }
    }
}
