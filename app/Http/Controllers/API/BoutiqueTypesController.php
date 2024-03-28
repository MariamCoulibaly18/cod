<?php

namespace App\Http\Controllers\API;

use App\Models\BoutiqueType;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class BoutiqueTypesController extends Controller
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
        //allow only super admin to access this route
        /*if(!Gate::allows('is-super-admin')){
            return response()->json([
                'message' => 'You are not authorized to access this resource',
            ], 403);
        }*/

        return BoutiqueType::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //allow only super admin to access this route
        // if(!Gate::allows('is-super-admin'))
        if(auth('api')->user()->type!='super_admin'){
            return response()->json([
                'message' =>  "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }

        //validate the request
        $this->validate($request,[
            'name'=>'required|string|max:191|unique:boutique_types',
        ]);
        // $boutiqueType = new BoutiqueType;
        $name = $request->name;
        $description = $request->description;

        // Vérifiez si une image a été téléchargée
        if ($request->hasFile('icon')) {
            // Utilisez Cloudder pour télécharger l'image vers Cloudinary
            Cloudder::upload($request->file('icon')->getRealPath(), null);
            
            // Récupérez l'URL de l'image depuis Cloudinary
            $icon = Cloudder::getResult()['url'];
        }

        $boutiqueType = BoutiqueType::create([
            'name'=> $name,
            'description'=> $description,
            'icon' => $icon, // Utilisez directement l'URL Cloudinary
        ]);
        $boutiqueType->save();
        return $boutiqueType;
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
        //allow only super admin to access this route
        // if(!Gate::allows('is-super-admin'))
        if(auth('api')->user()->type!='super_admin'){
            return response()->json([
                'message' =>  "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }

        $boutiqueType = BoutiqueType::findOrFail($id);
        
        //validate the request
        $this->validate($request,[
            'name'=>'required|string|max:191|unique:boutique_types,name,'.$boutiqueType->id,
        ]);

        //delete old image if new image is uploaded

        $boutiqueType->update($request->all());
        return ['message'=>'Mise à jour des informations sur le type de boutique'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //allow only super admin to access this route
        // if(!Gate::allows('is-super-admin'))
        if(auth('api')->user()->type!='super_admin'){
            return response()->json([
                'message' =>  "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }

        
        $boutiqueType = BoutiqueType::findOrFail($id);
        // delete the image from folder
        $image_path = public_path().'/images/stores/'.$boutiqueType->icon;
        if(file_exists($image_path)){
            @unlink($image_path);
        }
        // delete the user
        $boutiqueType->delete();
        return ['message'=>'Type de boutique supprimé'];
    }
}
