<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryExpense;
use App\Models\ParentCategory;
use App\Models\Provided;
use App\Models\TypeDepenses;
use Illuminate\Http\Request;

class CategoryDepensesController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typeBusinessExpense = TypeDepenses::where('name', "Business Expense")->first();
        $typeDepenseEquipe = TypeDepenses::where('name', "Team expense")->first();
        $categoryBusinessExpenses = CategoryExpense::with('parentCategory')->whereHas('typeDepense', function ($query) use ($typeBusinessExpense) {
            $query->where('id', $typeBusinessExpense->id);})
            ->get();
        $categoryTeamExpenses = CategoryExpense::whereHas('typeDepense', function ($query) use ($typeDepenseEquipe) {
             $query->where('id', $typeDepenseEquipe->id); })
             ->get();
        $categorys = CategoryExpense::with('parentCategory')->get();
        $livreurCategorys = CategoryExpense::whereHas('parentCategory', function ($query) {
            $query->where('name', 'service');
        })->get();
    
        return response()->json([
            'categoryBusinessExpenses' => $categoryBusinessExpenses,
            'categoryTeamExpenses' => $categoryTeamExpenses,
            'categorys' => $categorys,
            'livreurCategorys' => $livreurCategorys, // Ajoutez la collection livreurCategorys à la réponse JSON
        ], 200);
    }
    public function providedCategory(Request $request)
    {
        $providedId = $request->input('fourni_id');
        $typeTeamExpense = TypeDepenses::where('name', "Team Expense")->first();
        // Récupérer l'instance du modèle Provided correspondant à l'id fourni
        $provided = Provided::find($providedId);
        // Vérifier si le provided existe
        if (!$provided) {
            return response()->json(['message' => 'Le provided n\'existe pas'], 404);
        }
        $categoryTeamExpenses = CategoryExpense::with('parentCategory')->join('provided_parent_categorys', 'category_expenses.parent_category_id', '=', 'provided_parent_categorys.parent_id')
        ->where('provided_parent_categorys.provided_id', '=', $providedId)
        ->whereHas('typeDepense', function ($query) use ($typeTeamExpense) {
            $query->where('id', $typeTeamExpense->id);})
        ->get();

        return response()->json(['categoryTeamExpenses'=>$categoryTeamExpenses], 200);
 }
 public function parentCategory()
 {
    $parentCategorys = ParentCategory::with('categorys')->get();
     return response()->json(['parentCategorys'=>$parentCategorys], 200);
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
            'type_depense_id' => 'integer',
            'parent_category_id' => 'integer',
            'titre' => 'string',
        ]);
        return CategoryExpense::create([
            'type_depense_id'=> $request['type_depense_id'],
            'parent_category_id'=> $request['parent_category_id'],
            'titre'=> $request['titre'],
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
            'type_depense_id' => 'integer',
            'parent_category_id' => 'integer',
            'titre' => 'string',
        ]);

        $categoryExpense = CategoryExpense::findOrFail($id);
        $categoryExpense->type_depense_id = $request['type_depense_id'];
        $categoryExpense->parent_category_id = $request['parent_category_id'];
        $categoryExpense->titre = $request['titre'];
        $categoryExpense->save();
        return ['message'=>'Catégorie mise à jour avec succès', 'Categorie'=>$categoryExpense];
    
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
         $categorieExpense = CategoryExpense::findOrFail($id);
         $categorieExpense->delete();
         return ['message'=>'Categorie supprimée avec succès'];
    }
}
