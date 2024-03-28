<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Imports\ImportProduct;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
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
        $controller= 'App\Http\Controllers\API\\'.$type.'\ProductController';
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
          
        //validate the request
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'price' => 'required|numeric',
            'stock_status' => 'required|string|max:191',
            'pub_status' => 'required|string|max:191',
            'categories' => 'required|array',
            'brand' => 'required|string|max:191',
            'store' => 'required|numeric',
        ]);
        //stock quantity is required only when stock status is instock,sinon its 0
        if(strtolower($request->stock_status) != 'outofstock'){
            $this->validate($request, [
                'stock_quantity' => 'required|numeric|min:1',
            ]);
            
        }else{
            $request->merge(['stock_quantity' => 0]);
        }


        $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ProductController';
        return (new $controller)->store($request);
    }
    public function productApi(Request $request)
    {
          
        //validate the request
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lien' => 'required|string',
        ]);


        $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ProductController';
        return (new $controller)->productApi($request);
    }

    /**
     * import excel file
     */
    public function import(Request $request){
        //validation        
        /*$this->validate($request,[
            'store'=>'required|integer',
            'file'=>'required|mimes:xls,xlsx',//mimes : for specifie extention of file
        ]);*/
        
        //find boutique
        $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
        
        //import data
        $path = $request->file('file')->getRealPath();
        $data  = Excel::toArray(new ImportProduct(), $path);
        //netoyer les donnees , supprimer les lignes vides
        $clean_data = [];
        foreach($data[0] as $row){
            if($row['nom'] != null && $row['prix'] != null && $row['sku'] != null && $row['pub_status'] != null && $row['categories'] != null){
                $row['categories'] = explode("\n", $row['categories']);//explode is about to convert string to array
                $clean_data[] = $row;
            }
        }  
        
        //return $clean_data;
        $request->merge(['data'=>$clean_data]);
        //call import function for specific boutique type
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ProductController';   
        return (new $controller)->import($request);
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
        $controller= 'App\Http\Controllers\API\\'.$type.'\ProductController';
        return (new $controller)->show($store,$id);
    }
    /**
     * get attributes of product
     */

    public function getAttributes($store)
    {
        //
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ProductController';
        return (new $controller)->getAttributes($store);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        //validate the request
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'price' => 'required|numeric',
            'stock_status' => 'required|string|max:191',
            'pub_status' => 'required|string|max:191',
            'categories' => 'required|array',
            'store' => 'required|numeric',
        ]);
        //stock quantity is required only when stock status is instock,sinon its 0
        if(strtolower($request->stock_status) != 'outofstock'){
            $this->validate($request, [
                'stock_quantity' => 'required|numeric|min:1',
            ]);
        }else{
            $request->merge(['stock_quantity' => 0]);
        }
        
        $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ProductController';
        return (new $controller)->update($request, $product_id);
    }
    public function modificationEnMasse(Request $request)
    {
       $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
       $type = $boutique->type->name;
       $controller= 'App\Http\Controllers\API\\'.$type.'\ProductController';
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
        $controller= 'App\Http\Controllers\API\\'.$type.'\ProductController';
        return (new $controller)->supprimerEnMasse($request);
    }
    public function destroy($store,$product_id)
    {
        //
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\ProductController';
        return (new $controller)->destroy($store,$product_id);

    }
}
