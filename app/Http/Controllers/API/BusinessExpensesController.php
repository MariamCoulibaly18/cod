<?php

namespace App\Http\Controllers\Api;

use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BusinessExpense;

class BusinessExpensesController extends Controller
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
    public function index($store)
    {
        $boutique = Boutique::where('id', $store)->first();
        $businessExpenses = BusinessExpense::with('category')
            ->with('boutique')
            ->where('boutique_id', $store)
            ->get();

    
        return response()->json(['businessExpenses' => $businessExpenses,'boutique' => $boutique], 200);
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
            'category_id' => 'required|integer',
            'boutique_id' => 'required|integer',
            'montant' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|string|max:191',
            'note' => 'required|string|max:191',
        ]);
        
        return BusinessExpense::create([
            'category_id'=> $request['category_id'],
            'boutique_id'=> $request['boutique_id'],
            'montant'=> $request['montant'],
            'date'=> $request['date'],
            'status'=> $request['status'],
            'note'=> $request['note'],
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
        $this->validate($request,[
            'category_id' => 'integer',
            'boutique_id' => 'integer',
            'montant' => 'numeric',
            'date' => 'date',
            'status' => 'string|max:191',
            'note' => 'string|max:191',

        ]);

        $businessExpense = BusinessExpense::findOrFail($id);
        $businessExpense->category_id = $request['category_id'];
        $businessExpense->boutique_id = $request['boutique_id'];
        $businessExpense->montant = $request['montant'];
        $businessExpense->date = $request['date'];
        $businessExpense->status = $request['status'];
        $businessExpense->note = $request['note'];
        $businessExpense->save();
        return ['message'=>'Depense Updated Successfully', 'businessExpense'=>$businessExpense];
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
        $businessExpense = BusinessExpense::findOrFail($id);
        $businessExpense->delete();
        return ['message'=>'Depense Deleted Successfully'];
    }
}
