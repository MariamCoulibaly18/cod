<?php

namespace App\Http\Controllers\Api;

use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TeamExpense;

class TeamExpensesController extends Controller
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
        $teamExpenses = TeamExpense::with('category')
            ->with('boutique')
            ->with('user')
            ->with('provided')
            ->where('boutique_id', $store)
            ->get();
        return response()->json(['teamExpenses' => $teamExpenses, 'boutique' => $boutique], 200);
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
        $this->validate($request, [
            'category_id' => '',
            'boutique_id' => '',
            'user_id' => '',
            'provided_id' => '',
            'montant' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|string|max:191',
            'note' => 'required|string|max:191',
        ]);
        
        return TeamExpense::create([
            'category_id'=> $request['category_id'],
            'user_id'=> $request['user_id'],
            'provided_id'=> $request['provided_id'],
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
         //
         $this->validate($request,[
            'category_id' => '',
            'boutique_id' => '',
            'user_id' => '',
            'provided_id' => '',
            'montant' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|string|max:191',
            'note' => 'required|string|max:191',

        ]);

        $teamExpense = TeamExpense::findOrFail($id);
        $teamExpense->category_id = $request['category_id'];
        $teamExpense->boutique_id = $request['boutique_id'];
        $teamExpense->provided_id = $request['provided_id'];
        $teamExpense->user_id = $request['user_id'];
        $teamExpense->montant = $request['montant'];
        $teamExpense->date = $request['date'];
        $teamExpense->status = $request['status'];
        $teamExpense->note = $request['note'];
        $teamExpense->save();
        return ['message'=>'Depense mise à jour avec succès', 'teamExpense'=>$teamExpense];
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
        $teamExpense = TeamExpense::findOrFail($id);
        $teamExpense->delete();
        return ['message'=>'Dépense supprimée avec succès'];
    }
}
