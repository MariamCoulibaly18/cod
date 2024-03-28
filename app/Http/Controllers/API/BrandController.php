<?php

namespace App\Http\Controllers\Api;

use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
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
          $controller= 'App\Http\Controllers\API\\'.$type.'\BrandController';
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
           
           $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
           $type = $boutique->type->name;
           $controller= 'App\Http\Controllers\API\\'.$type.'\BrandController';
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
    public function update(Request $request, $brand_id)
    {
         //
         $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
         $type = $boutique->type->name;
         $controller= 'App\Http\Controllers\API\\'.$type.'\BrandController';
         return (new $controller)->update($request, $brand_id);
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
        $controller= 'App\Http\Controllers\API\\'.$type.'\BrandController';
        return (new $controller)->supprimerEnMasse($request);
    }
    public function destroy($store,$brand_id)
    {
        //
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\BrandController';
        return (new $controller)->destroy($store,$brand_id);
    }
}
