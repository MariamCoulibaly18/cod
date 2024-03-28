<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Type;
use App\Models\Facture;
use App\Models\Boutique;
use App\Models\Commande;
use App\Models\Payement;
use Illuminate\Http\Request;
use App\Mail\sendFactureMail;
use App\Models\FactureDirect;
use App\Models\FactureIndirect;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use App\Providers\FacturePdfProvider;
use function PHPUnit\Framework\isEmpty;

class FactureController extends Controller
{
    /*
    *constructor
    */
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    //update facture
    public function update(Request $request,$facture)
    {
        //return $request->all();
        $boutique = Boutique::where('id', $request->store)->with('factures')->first();
        $facture = $boutique->factures->where('id', $facture)->first();

        $facture->update([
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Facture updated successfully'], 200);
    }
    // send mail facture
    public function sendMail(Request $request,$facture_id)
    {
    
        $facture = Facture::where('id', $facture_id)->with('boutique')->firstOrFail();
        // dd($facture->is_direct);
        if(!$facture->is_direct){ 
            throw new \Exception("Facture déjà payée", 400);
        }

        $boutique = $facture->boutique;
        $payment_status = $facture->payement_status;
        $due = (new PayementController)->getDue($facture->id);
        //return response()->json($boutique, 200);
        try{
            $factureData = [
                'store' => $boutique->name,
                'order_date' => date('d/m/Y'),
                'total' => $facture->total,
                'company' => 'GTEL'
            ];
            //get pdf
            $facture_direct = FactureDirect::where('id', $facture->facture_type_id)->first();
            // $pdf = file_get_contents(public_path('factures\\' . $facture_direct->pdf));
            $pdf_path = public_path('factures\\' . $facture_direct->pdf);
            $pdf = FacturePdfProvider::getFactureDirect($pdf_path,$payment_status,$due);
            
            Mail::send(new sendFactureMail($request->email,$pdf,$factureData));
            return response()->json(['message' => 'Facture sent successfully to '.$request->email], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Facture not sent','error' => $e->getMessage(),'trace' => $e->getTrace()], 400);
        }
    }

    // send mail facture
    /*public function sendMail($facture_id)
    {
    
        $facture = Facture::where('id', $facture_id)->with('boutique')->firstOrFail();
        $boutique = $facture->boutique;
        //return response()->json($boutique, 200);
        try{
            $factureData = [
                'store' => $boutique->name,
                'order_date' => date('d/m/Y'),
                'total' => $facture->total,
                'company' => 'GTEL'
            ];

            Mail::send(new sendFactureMail($facture->email,$facture->pdf,$factureData));
            return response()->json(['message' => 'Facture sent successfully to '.$facture->email], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Facture not sent','error' => $e->getMessage(),'trace' => $e->getTrace()], 400);
        }
    }*/
    /********************* Facture Indrect ********************************************/
    //par process
    
    /**
     * methode index
     *
     */

    public function getProcessFactures($store){

        $factures = Facture::where('boutique_id', $store)->where('is_direct',0)->get();
        $factures_process = [];
        foreach($factures as $facture){
            $facture_indirect = FactureIndirect::where('id', $facture->facture_type_id)->firstOrFail();
            if($facture_indirect->type == 'pr'){
                $orderResponse = (new OrderController)->show($facture->boutique_id, $facture_indirect->facture_type_id);
                $order = json_decode($orderResponse->getContent()); // Convertir la réponse JSON en objet PHP
                // //array to object
                // $order = (object) $order;
                $factures_process[] = [
                    'id' => $facture->id,
                    'client' => $order->client->first_name.' '.$order->client->last_name,
                    'email' => $order->client->email,
                    'total' => $facture->total,
                    'due' => (new PayementController)->getDue($facture->id),
                    'status' => $facture->status,
                    'date' => $facture->created_at,
                    'payment_status' => $facture->payement_status,
                ];

            }
        }
        return response()->json($factures_process, 200);
    }

    /**
     * methode store
     */
    public function createProcessFacture(Request $request)
    {
        //validation { order_id , store }
        $request->validate([
            'order_id' => 'required|integer',
            'store' => 'required|integer',
        ]);

        //get the order by Id using OrderController show method
        $orderResponse = (new OrderController)->show($request->store, $request->order_id);
        $order = json_decode($orderResponse->getContent()); // Convertir la réponse JSON en objet PHP
        //test if order is completed
        if($order->status != 'completed'){
            return response()->json(['message' => 'Order not completed'], 400);
        }
        //create facture indrect
        try{
            DB::beginTransaction();
            $facture_process = FactureIndirect::create([
                'facture_type_id' => $request->order_id,
                'type' => 'pr'
            ]);
            
            $facture = Facture::create([
                'total' => $order->total,
                'status' => 'ferme',
                'payement_status' => 'incomplet',
                'facture_type_id' => $facture_process->id,
                'boutique_id' => $request->store,
            ]);

            //call payement  controller for store payement
            $request->merge(['facture' => $facture->id]);
            $request->merge(['montant' => $order->total]);

            (new PayementController)->store($request);
            
            DB::commit();
            return response()->json(['message' => 'Facture created successfully','facture' => $facture], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => 'Facture not created','error' => $e->getMessage()], 400);
        }

    }

    /**
     * methode export
     */
    public function exportProcessFacture($facture){
        try{
            DB::beginTransaction();
            //generate article format pdf
            $facture = Facture::where('id', $facture)->where('is_direct',0)->with('boutique')->first();
            $boutique = $facture->boutique;
            $facture_indirect = FactureIndirect::where('id', $facture->facture_type_id)->first();
            $orderResponse = (new OrderController)->show($facture->boutique_id, $facture_indirect->facture_type_id);
            $order = json_decode($orderResponse->getContent()); // Convertir la réponse JSON en objet PHP
            // $order = (object) $order;
            $data = [
                'numero_facture' => 'F' . uniqid(),
                'due' => (new PayementController)->getDue($facture->id),
                'payment_status' => $facture->payement_status,
                //personne
                'client' => $order->client->first_name.' '.$order->client->last_name,
                'email' => $order->client->email,
                'telephone' => $order->client->phone,
                'adresse' => $order->client->adress,
                'ville' => 'Casablanca',
                'pays' => $order->client->country,
                //order
                'order_id' =>$order->id,
                'total' => $facture->total,
                'line_items' => $order->products,
                'date' => $order->created_at,
                'shipping_total' => $order->shipping_total,
                'shipping_tax' => $order->shipping_tax,
                //store
                'store' => $boutique->name,
                'icon' => $boutique->type['icon'],
            ];
            // var_dump($data['line_items']);
            // dd($data);
            FacturePdfProvider::downloadFactureIndirect($data,'client');
            return response()->json(['message' => 'Facture  exportée'], 200);
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => 'Facture non exportée','error' => $e->getMessage()], 400);
        }
    }

    //par transaction
    /**
     * methode index
     *
     */
    public function getTransactionFactures($store){

        $factures = Facture::where('boutique_id', $store)->where('is_direct',0)->get();
        $factures_transaction = [];

        foreach($factures as $facture){
            // dd($facture);
            $facture_indirect = FactureIndirect::where('id', $facture->facture_type_id)->first();
            // dd($facture_indirect);
            if($facture_indirect->type == 'tr'){
                $transaction = (new TransactionController)->show($facture->boutique_id, $facture_indirect->facture_type_id);
                //array to object
                $transaction = (object) $transaction;
                if($transaction->is_visible == 0)
                continue;
                $factures_transaction[] = [
                    'id' => $facture->id,
                    'transaction_id' => $facture_indirect->facture_type_id,
                    'fournisseur' => $transaction->fournisseur['name'],
                    'total' => $facture->total,
                    'due' => (new PayementController)->getDue($facture->id),
                    'status' => $facture->status,
                    'date' => $facture->created_at,
                    'payment_status' => $facture->payement_status,
                ];
            }
        }

        return response()->json($factures_transaction, 200);
    }
    /**
     * methode store
     */
    public function createTransactionFacture(Request $request)
    {
        //validation { transaction_id , store }
        $request->validate([
            'transaction_id' => 'required|integer',
            'store' => 'required|integer',
        ]);

        //get the order by Id using OrderController show method
        $transaction = (new TransactionController)->show($request->store,$request->transaction_id);
        //create facture indrect
        try{
            DB::beginTransaction();
            $facture_transaction = FactureIndirect::create([
                'facture_type_id' => $request->transaction_id,
                'type' => 'tr'
            ]);
            
            $facture = Facture::create([
                'total' => $transaction['total'],
                'status' => 'ouvert',
                'payement_status' => 'incomplet',
                'facture_type_id' => $facture_transaction->id,
                'boutique_id' => $request->store,
            ]);        
            DB::commit();
            return response()->json(['message' => 'Facture créée avec succès','facture' => $facture], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => 'Facture non créée','error' => $e->getMessage()], 400);
        }

    }

    /**
     * methode export
     */
    public function exportTransactionFacture($facture){
        try{
            DB::beginTransaction();
            //generate article format pdf
            $facture = Facture::where('id', $facture)->where('is_direct',0)->with('boutique')->first();
            $boutique = $facture->boutique;
            $facture_indirect = FactureIndirect::where('id', $facture->facture_type_id)->first();
            $transaction = (new TransactionController)->show($facture->boutique_id, $facture_indirect->facture_type_id);
            $transaction = (object) $transaction;
            $data = [
                'numero_facture' => 'F' . uniqid(),
                'due' => (new PayementController)->getDue($facture->id),
                'payment_status' => $facture->payement_status,
                //fournisseur
                'fournisseur' => $transaction->fournisseur['name'],
                'type' => $transaction->fournisseur->type['type'],
                'telephone' => $transaction->fournisseur['telephone'],
                'adresse' => $transaction->fournisseur['adresse'],
                'transaction_id'=>$transaction->id,
                /*'ville' => 'Casablanca',
                'pays' => $transaction->fournisseur['country'],*/
                //marque
                'marque_name' => $transaction->marque['name'],
                'marque_logo' => $transaction->marque['logo'],
                //transaction
                'transaction_id'=> $transaction->id,
                'product_name' => $transaction->produit_name,
                'product_quantity' => $transaction->quantite,
                'product_price' => $transaction->prix,
                'total' => $facture->total,
                'date' => Carbon::parse($facture->created_at)->format('d/m/Y'),
                //store
                'store' => $boutique->name,
                'icon' => $boutique->type['icon'],
            ];
            FacturePdfProvider::downloadFactureIndirect($data,'fournisseur');

            DB::commit();
            return response()->json(['message' => 'Facture exportée avec succès'], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message' => 'Facture non exportée','error' => $e->getMessage(),'trace' => $e->getTrace()], 400);
        }
    }    

    /************************    Direct        *******************/
    /**
     * methode index
     *
     */
    public function getDirectFactures($store){

        $factures = Facture::where('boutique_id', $store)->where('is_direct', 1)->get();
        $factures_direct = [];
        try{
            foreach($factures as $facture){
                $facture_direct = FactureDirect::where('id', $facture->facture_type_id)->first();
                $facture_direct = (object) $facture_direct;

                $factures_direct[] = [
                    'id' => $facture->id,
                    'client' => $facture_direct->client,
                    "email" => $facture_direct->email,
                    'total' => $facture->total,
                    'due' => (new PayementController)->getDue($facture->id),
                    'status' => $facture->status,
                    'date' => $facture->created_at,
                    'payment_status' => $facture->payement_status,
                ];
                
                  

                
            }
    
            return response()->json($factures_direct, 200);
        
        }catch(\Exception $e){
            return response()->json(['message' => 'Facture not found','error' => $e->getMessage()], 400);
        }
    }

    
    
    /**
     * methode store
     */
    public function createDirectFacture(Request $request)
    {
        
        //generate article format pdf
        $boutique = Boutique::where('id', $request->store)->with('type')->first();
        $data = [
            'numero_facture' => 'F' . uniqid(),
            //'due' => $request->total,
            //'payment_status' => 'incomplet',
            //personne
            'client' => $request->client,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'ville' => 'Casablanca',
            'pays' => $request->pays,
            //order
            'total' => $request->total,
            'line_items' => $request->line_items,
            'shipping_total' => $request->shipping_total,
            'date' => date('d/m/Y'),
            //store
            'store' => $boutique->name,
            'icon' => $boutique->logo,

            // 'logo' => $boutique->logo,
        ];
  
        try{
            DB::beginTransaction();

           $facture_direct = FactureDirect::Create([
                'client' => $request->client,
                'email' => $request->email,
                'total' => $request->total,
                'pdf' => $data['numero_facture'].'.pdf',
            ]);

            Facture::Create([
                'total' => $request->total,
                'status' => 'ouvert',
                'payement_status' => 'incomplet',
                'is_direct'=> true,
                'facture_type_id' => $facture_direct->id,
                'boutique_id' => $request->store,
            ]);

            FacturePdfProvider::generatePDF($data, 'client');

            
            DB::commit();
            return response()->json(['message' => 'Facture created successfully','facture' => '$facture'], 200);
            
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message2' => 'Facture not created','error' => $e->getMessage()], 400);
        }


        // //generate article format pdf
        // $boutique = Boutique::where('id', $request->store)->with('type')->first();
        // $data = [
        //     'numero_facture' => 'F' . uniqid(),
        //     'due' => $request->total,
        //     'payment_status' => 'incomplet',
        //     //personne
        //     'email' => $request->email,
        //     'telephone' => $request->telephone,
        //     'adresse' => $request->adresse,
        //     'ville' => 'Casablanca',
        //     'pays' => $request->pays,
        //     //order
        //     'total' => $request->total,
        //     'line_items' => $request->line_items,
        //     'date' => date('d/m/Y'),
        //     //store
        //     'store' => $boutique->name,
        //     'icon' => $boutique->type['icon'],
        // ];

        // try{
        //     DB::beginTransaction();

        //    $facture_direct = FactureDirect::Create([
        //         'client' => $request->client,
        //         'email' => $request->email,
        //         'total' => $request->total,
        //         'pdf' => $data['numero_facture'].'.pdf',
        //     ]);
            
        //     Facture::Create([
        //         'total' => $request->total,
        //         'status' => 'ouvert',
        //         'payement_status' => 'incomplet',
        //         'is_direct'=> true,
        //         'facture_type_id' => $facture_direct->id,
        //         'boutique_id' => $request->store,
        //     ]);
            
        //     $data['client'] =  $request->client;
        //     FacturePdfProvider::generatePDF($data, 'client');
            
            
        //     DB::commit();
        //     return response()->json(['message' => 'Facture created successfully','facture' => '$facture'], 200);
            
        // }catch(\Exception $e){
        //     DB::rollback();
        //     return response()->json(['message2' => 'Facture not created','error' => $e->getMessage()], 400);
        // }

        
    }

    /**
     * methode export
     */    
    public function exportDirectFacture($facture)
    {
        $facture = Facture::where('id', $facture)->first();
        $facture_direct = FactureDirect::where('id', $facture->facture_type_id)->first();

        $pdf = public_path('factures/' . $facture_direct->pdf);
        // dd($pdf);
        $due = (new PayementController)->getDue($facture->id);
        $payment_status = $facture->payement_status;

        return FacturePdfProvider::downloadFactureDirect($pdf,$payment_status,$due);

    }

}