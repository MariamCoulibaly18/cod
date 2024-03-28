<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Imports\ImportClient;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
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
        $controller= 'App\Http\Controllers\API\\'.$type.'\CustomerController';
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
        //validation
        $this->validate($request, [
            'store'=>'required|integer',
            'first_name'=>'required|string|max:191|regex:/^[\pL\s\-]+$/u',
            'last_name'=>'required|string|max:191|regex:/^[\pL\s\-]+$/u',
            'email'=>'required|string|email|max:191',
            'telephone'=>'required|digits:10',
            'country'=>'required|string|max:191',
            'adresse'=>'required|string|max:191',
        ]);
        //
        $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\CustomerController';
        
        return (new $controller)->store($request);
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
        $data  = Excel::toArray(new ImportClient(), $path);
        $clean_data = [];
        foreach($data[0] as $row){
            if($row['nom'] != null && $row['prenom'] != null && $row['email'] != null && $row['telephone'] != null && $row['adresse'] != null && $row['pays'] != null){
                $row['telephone'] = str_replace('"', '', $row['telephone']);
                $clean_data[] = $row;
            }
        }

        $request->merge(['data'=>$clean_data]);

        //call import function for specific boutique type
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\CustomerController';   
        return (new $controller)->import($request);
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
        //validations
        $this->validate($request,[
            'store'=>'required|integer',
            'first_name'=>'required|string|max:191|regex:/^[\pL\s\-]+$/u',
            'last_name'=>'required|string|max:191|regex:/^[\pL\s\-]+$/u',
            'email'=>'required|string|email|max:191',
            'telephone'=>'required|digits:10',
            'country'=>'required|string|max:191',
            'adresse'=>'required|string|max:191',
        ]);
        //
        $boutique = Boutique::where('id', $request->store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\CustomerController';
        return (new $controller)->update($request, $costumer_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($store, $customer_id)
    {
        //
        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\CustomerController';
        return (new $controller)->destroy($store, $customer_id);
    }
    
}
