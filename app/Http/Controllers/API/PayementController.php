<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Models\Payement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayementController extends Controller
{
    /*
    *constructor
    */
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    //get the due amount of a facture
    public function getDue($facture)
    {
        $facture = Facture::where('id', $facture)->with('payements')->first();
        $total = $facture->total;
        $payements = $facture->payements;

        foreach ($payements as $payement) 
            $total -= $payement->montant;

        return $total;
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($facture)
    {
        //
        $facture = Facture::where('id', $facture)->with('payements')->first();
        $payements = $facture->payements;

        $data = [
            'history' => collect($payements)->map(function ($payement) {
                return [
                    'id' => $payement->id,
                    'amount' => $payement->montant,
                    'date' => $payement->created_at,
                ];
            }),
            'total' => $facture->total,
            'due' => $this->getDue($facture->id),
        ];

        return response()->json($data, 200);
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
        try{

            DB::beginTransaction();
            //create a payement for this facture
            Payement::create([
                'montant' => $request->montant,
                'facture_id' => $request->facture,
            ]);

            //test si la facture est completée
            $facture = Facture::where('id',$request->facture)->firstOrFail();

            if(! $this->getDue($facture->id) ){
                $facture->payement_status = 'paye';
                $facture->save();
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Payement effectué avec succès'
            ], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message2' => 'Facture not created','error' => $e->getMessage()], 400);
        }

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
    public function destroy($payement)
    {
        //
        
        try{

            DB::beginTransaction();
            
            //delete payement
            $payement = Payement::where('id', $payement)->with('facture')->firstOrFail();
            $payement->delete();

            //test si la facture est incompletée
            $facture = $payement->facture;
            if($this->getDue($facture->id) ){
                $facture->payement_status = 'incomplet';
                $facture->save();
            }    


            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Payement effectué avec succès'
            ], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['message2' => 'Facture not created','error' => $e->getMessage()], 400);
        }
    }
}
