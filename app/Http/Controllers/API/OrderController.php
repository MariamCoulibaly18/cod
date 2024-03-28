<?php

namespace App\Http\Controllers\API;

use App\Models\Boutique;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\FacturePdfProvider;

class OrderController extends Controller
{
    /*
    *constructor
    */
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($store)
    {
        //
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\OrderController';
        return (new $controller)->index($store);
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
        $controller= 'App\Http\Controllers\API\Local\OrderController';
        return (new $controller)->store($request);
    }
        public function exportBonDeCommande($store_id,$commande)
        {
            $boutique = Boutique::where('id', $store_id)->with('type')->firstOrFail();
            dd($boutique);
            $type = $boutique->type->name;
            $controller= 'App\Http\Controllers\API\\'.$type.'\OrderController';
            return (new $controller)->exportBonDeCommande($store_id, $commande);
            $commande = Commande::where('id', $commande)->first();
                // $pdf = public_path('bon_de_commande/' . $commande->bon_de_commande);

                // return FacturePdfProvider::downloadBonCommande($pdf);
                //return response()->download($pdf);
        }
    
    public function updateStatutLivraison(Request $request, $orderId)
    {
    
        $store_id = $request->input('store_id');
        $boutique = Boutique::where('id', $store_id)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\OrderController';
        return (new $controller)->updateStatutLivraison($request, $orderId);
    }
    /**
     * export orders to excel
     */

    public function export($store)
    {
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\OrderController';
        return (new $controller)->export($store);
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
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\OrderController';
        return (new $controller)->show($store,$id);
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
        //validation 
        
        $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\OrderController';
        return (new $controller)->update($request, $id);

    }

    /**
     * update multiple orders
     */
    public function modificationEnMasse(Request $request)
    {
       $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
           $type = $boutique->type->name;
           $controller= 'App\Http\Controllers\API\\'.$type.'\OrderController';
           return (new $controller)->modificationEnMasse($request);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function supprimerEnMasse(Request $request)
    {
        //
        $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\OrderController';
        return (new $controller)->supprimerEnMasse($request);
    }
    public function destroy($store,$id)
    {
        //
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\OrderController';
        return (new $controller)->destroy($store,$id);
    }
}
