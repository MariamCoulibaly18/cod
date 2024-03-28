<?php

namespace App\Http\Controllers\Api;

use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Models\SocieteTransport;
use App\Http\Controllers\Controller;
use App\Providers\WooCommerceService;

class SocieteTransportController extends Controller
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
        $boutique = Boutique::where('id', $store)->firstOrFail();
        $societeTransports = SocieteTransport::with('boutique')->where('boutique_id', $store)->get();
        return response()->json(['societeTransport' => $societeTransports, 'boutique' => $boutique],200);

        return response()->json($societeTransports,200);
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
            'adresse'=>'required|string|max:191',
            'telephone'=>'required',
            'boutique_id' => 'required',            

        ]);
        return SocieteTransport::create([
            'name'=> $request['name'],
            'adresse'=> $request['adresse'],
            'telephone'=> $request['telephone'],
            'boutique_id'=> $request['boutique_id'],
        ]);
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
            'name'=>'string|max:191',
            'adresse'=>'string|max:191',
            'telephone'=>'',
            'boutique_id' => '',            

        ]);

        $societeTransport = SocieteTransport::findOrFail($id);
        $societeTransport->name = $request['name'];
        $societeTransport->adresse = $request['adresse'];
        $societeTransport->telephone = $request['telephone'];
        $societeTransport->boutique_id = $request['boutique_id'];
        $societeTransport->save();
        return ['message'=>'societeTransport Updated Successfully', 'societeTransport'=>$societeTransport];
    }
    public function connect($societeTransport){

        $societeTransport = SocieteTransport::where('id', $societeTransport)->with('boutique')->firstOrFail();
       
            return response()->json(['message' => 'This is a societe de transport'], 422);
        }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $societeTransports = SocieteTransport::findOrFail($id);
        $societeTransports->delete();
        return ['message'=>'Societe de transport Deleted Successfully'];
    }
}
