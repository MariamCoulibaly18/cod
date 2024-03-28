<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Livreur;
use App\Models\SocieteTransport;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class LivreurController extends Controller
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
    public function index($id)
    {
        // $societeTransport = SocieteTransport::where('id', $id)->firstOrFail();
        // $livreurs= Livreur::with('societeTransport')->with('user')->where('societeTransport_id', $id)->get();
        // return response()->json(['societeTransport' => $societeTransport, 'livreur' => $livreurs],200);
        $societeTransport = SocieteTransport::where('id', $id)->firstOrFail();
        $livreurs = Livreur::where('societeTransport_id', $id)->with('user')->get();
        return response()->json(['societeTransport' => $societeTransport, 'livreur' => $livreurs], 200);

        // return response()->json($livreurs,200);
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
            'adresse' => 'string|max:191',
            'telephone' => 'required',
            'matricule' => 'required|string|max:191',
            'societeTransport_id' => 'required',
            'user_id' => 'required|integer',
        ]);

        return Livreur::create([
            'adresse' => $request['adresse'],
            'telephone' => $request['telephone'],
            'matricule' => $request['matricule'],
            'status' => null,
            'societeTransport_id' => $request['societeTransport_id'],
            'user_id' => $request['user_id'],
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
            'adresse'=>'string|max:191',
            'telephone'=>'required',
            'matricule'=>'required|string|max:191',
            'societeTransport_id' => 'required',            
            'user_id' => 'required',                     
        ]);

        $livreur = Livreur::findOrFail($id);
        $livreur->adresse = $request['adresse'];
        $livreur->telephone = $request['telephone'];
        $livreur->matricule = $request['matricule'];
        $livreur->societeTransport_id = $request['societeTransport_id'];
        $livreur->user_id = $request['user_id'];
        $livreur->save();
        return ['message'=>'Livreur Updated Successfully', 'livreur'=>$livreur];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $livreur = Livreur::findOrFail($id);
        $livreur->delete();
        return ['message'=>'livreur Deleted Successfully'];
    }
}
