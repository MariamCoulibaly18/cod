<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
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
        $boutique = Boutique::where('id',$store)->with('type')->firstOrFail();

        //allow only super admin or responsible of the store to connect to the store
        if(auth('api')->user()->type!='super_admin' && !Gate::allows('is-responsible',$boutique)){
            return response()->json([
                'message' =>  "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }

        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\CategoryController';
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
            'name' => 'required|string|max:191',
            'store' => 'required|integer',
        ]);
        $boutique = Boutique::where('id',$request->store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\CategoryController';
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_id)
    {
        //validation
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'store' => 'required|integer',
        ]);
        //
        $boutique = Boutique::where('id',$request->store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\CategoryController';
        return (new $controller)->update($request,$category_id);
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
        $controller= 'App\Http\Controllers\API\\'.$type.'\CategoryController';
        return (new $controller)->supprimerEnMasse($request);
    }
    public function destroy($store,$category_id)
    {
        //
        $boutique = Boutique::where('id',$store)->with('type')->firstOrFail();
        $type = $boutique->type->name;
        $controller= 'App\Http\Controllers\API\\'.$type.'\CategoryController';
        return (new $controller)->destroy($store,$category_id);
    }
}
