<?php

namespace App\Http\Controllers\Api;

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
          //
          $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
          $type = $boutique->type->name;
          $controller= 'App\Http\Controllers\API\\'.$type.'\PointVentesController';
          return (new $controller)->index($store);
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
            'client' => '',
            'telephone' => '',
            'ville' => '',
            'type_payement' => '',
            'type_echange_commercial' => '',
            'order_id' => '',
            'boutique_id' => '',
            'customer_id' => '',
        ]);
        $boutique = Boutique::where('id', $request->boutique_id)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\PointVentesController';
        return (new $controller)->store($request);
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
        $this->validate($request,[
            'type_echange_commercial'=>'',
            'type_payement'=>'',
        ]);

        $pointVente = PointVente::findOrFail($id);
        $pointVente->type_echange_commercial = $request['type_echange_commercial'];
        $pointVente->type_payement = $request['type_payement'];
        $pointVente->save();
        return ['message'=>'Point de vente Updated Successfully', 'pointVente'=>$pointVente];
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

