<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Client;
use App\Models\Livreur;
use App\Models\Commande;
use App\Models\Template;
use App\Models\Messagerie;
use Illuminate\Http\Request;
use App\Models\ApiMessagerie;
use App\Models\StatutLivraison;
use App\Models\LivreurCommandes;
use Vonage\Client as VonageClient;
use App\Http\Controllers\Controller;
use Vonage\Client\Credentials\Basic as VonageCredentials;

class StatutLivraisonsController extends Controller
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
        $statusLivraisons= StatutLivraison::get();
        $statusLivraisonsOrders = StatutLivraison::whereNotIn('status', ['livrer', 'Livrer'])->get();

        return response()->json(['statusLivraisons'=>$statusLivraisons,'statusLivraisonsOrders'=>$statusLivraisonsOrders],200);
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
        $this->validate($request,[
            'status' => 'string|required',
        ]);          
        return StatutLivraison::create([
            'status'=> $request['statut_livraison'],
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
