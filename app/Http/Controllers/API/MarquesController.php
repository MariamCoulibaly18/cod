<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marque;
use Illuminate\Http\Request;

class MarquesController extends Controller
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
    public function index()
    {
        $marques = Marque::all();
        return response()->json(['data' => $marques], 200);
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
        $this->validate($request,[
            'name'=>'required|string|max:191',
            'description'=>'string',
            'logo'=>'string|max:191',

        ]);
        return Marque::create([
            'name'=> $request['name'],
            'description'=> $request['description'],
            'logo'=> $request['logo'],
        ]);
        
        // if($request->hasFile('logo')){
        //     $file = $request->file('logo');
        //     $extension = $file->getClientOriginalExtension();
        //     $file->move(public_path().'/images/stores/', $request['name'].'.'.$extension);
        //     $marques->logo = $request['name'].'.'.$extension;
        // }

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
        $this->validate($request,[
            'name'=>'required|string|max:191',
            'description'=>'string',
            'logo'=>'string|max:191',
        ]);

        $marque = Marque::findOrFail($id);
        $marque->name = $request['name'];
        $marque->description = $request['description'];
        $marque->logo = $request['logo'];
        $marque->save();
        return ['message'=>'Marque Updated Successfully', 'marque'=>$marque];
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
         $marque = Marque::findOrFail($id);
         $marque->delete();
         return ['message'=>'Boutique Deleted Successfully'];
    }
}
