<?php

namespace App\Http\Controllers\API;

use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
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
    public function index()
    {
        //

    }
    public function produitVendus($store)
    {
        //
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\DashboardController';
        return (new $controller)->produitVendus($store);
    }
    function commandes($store){
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\DashboardController';
        return (new $controller)->commandes($store);
    }
    function ventes($store){
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\DashboardController';
        return (new $controller)->ventes($store);
    }
    function calculTaux($store){
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\DashboardController';
        return (new $controller)->calculTaux($store);
    }
    public function nombreBoutiques()
    {
        if(auth('api')->user()->type=='super_admin'){
            // $fournisseurMarques = FournisseurMarques::with('fournisseur')->with('marque')->get();
            $boutiques = Boutique::with('type')->with('user')->get();
            $nombreBoutiques = count($boutiques);
            // dd($nombreBoutiques);

        }else if(auth('api')->user()->type=='admin'){
            $boutiques= Boutique::where('user_id',auth('api')->user()->id)->with('type')->with('user')->get();
            $nombreBoutiques = count($boutiques);
        }
        return response()->json([
            'nombreBoutiques' => $nombreBoutiques,
        ], 200);
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
