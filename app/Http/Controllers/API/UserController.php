<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\ProfileUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //constructor
    public function __construct()
    {
        //middleware
        //$this->authorize('is-super-admin');
        $this->middleware('auth:api');
    }

    public function index()
    {   
        if(auth('api')->user()->type=='super_admin'){
            $user= User::latest()->get();
            return response()->json(['data' => $user]);
        }

        //return User::latest()->paginate(10);
        return response()->json([
            'message' => "Vous n'êtes pas autorisé à accéder à cette ressource",
        ], 403);
    }
    public function getUserImage() {
        // Récupérez l'utilisateur authentifié
        $user = auth('api')->user();
    
        // Récupérez le chemin de l'image de l'utilisateur
        $imagePath = public_path('/images/profile/' . $user->image);
    
        // Manipulez l'image comme vous le souhaitez (modification dynamique)
        // Exemple: redimensionner, filtrer, etc.
    
        // Retournez la réponse avec le contenu de l'image
        return response()->file($imagePath);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //allow only super admin to create user
        // if(!Gate::allows('is-super-admin'))
        if(!auth('api')->user()->type=='super_admin'){
            return response()->json([
                'message' =>"Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }
        
        //return $request->all();
        $this->validate($request,[
            'name'=>'required|string|max:191',
            'email'=>'required|string|email|max:191|unique:users',
            'password'=>'required|string|min:6',
            'password_confirmation'=>'required|string|min:6',
        ]);
        //si le type est dans le formulaire on le valide
        if($request->type){
            $this->validate($request,[
                'type'=>'required|string|max:191',
            ]);
        }
        return User::create([
            'name'=> $request['name'],
            'email'=> $request['email'],
            'password'=>Hash::make($request['password']),
            'type'=> $request['type'],
        ]);
        
    
    }


    public function updateProfile(Request $request){

        //all users are allowed to update their profile
        $user = auth('api')->user();
        $user = User::findOrFail($user->id);        
        

        $this->validate($request,[
            'name'=>'required|string|max:191',
            'email'=>'required|string|email|max:191|unique:users,email,'.$user->id,
            'password'=>'sometimes|required|min:6',
            'confirm_password'=>'sometimes|required|min:6',
        ]);

        $user->name=$request['name'];
        $user->email=$request['email'];
        
        if(!empty($request->image) && $request->image != 'profile.jpg'){
            if($request->image != $user->image){
                $name = time().'.'.explode('/',explode(':',substr($request->image,0,strpos($request->image,';')))[1])[1]; 
                //test if image exist in public folder
                if($name != $user->image && !file_exists(public_path('images/profile/').$name)){
                    //delete image
                    //unlink(public_path('images/profile/').$user->image);
                    //image in public folder
                    Image::make($request->image)->save(public_path('images/profile/').$name);
                    //image in database put new value with merge function        
                    $user->image=$name;
                }
            }
        }else{
            $user->image='profile.jpg';
        }

        if(!empty($request->password)){
            $request->merge(['password'=> Hash::make($request['password'])]);
            $user->password=$request['password'];
        }
        
        $user->save();
        // broadcast(new ProfileUpdated(auth()->user()));

        return['message'=> 'success'];

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
        //allow only super admin to update user
        // if(!Gate::allows('is-super-admin'))
        if(auth('api')->user()->type!='super_admin'){
            return response()->json([
                'message' => "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }

        $user = User::findOrFail($id);
        
        $this->validate($request,[
            'name'=>'required|string|max:191',
            'email'=>'required|string|email|max:191|unique:users,email,'.$user->id,
            'password'=>'sometimes|min:6'
        ]);
        if(!empty($request->password)){
            $request->merge(['password'=> Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message'=> 'updated user info'];
        // return response()->json(['message'=> 'updated user info']);
    }
    public function showNotifications()
{
    $adminId = auth()->user()->id;
    $adminNotifications = session("admin_notifications." . $adminId, []);

    // Marquer les notifications comme lues, si nécessaire
    // Par exemple, en supprimant les notifications de la session une fois qu'elles ont été affichées.

    return view('notifications', compact('adminNotifications'));
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //allow only super admin to delete user
        // if(!Gate::allows('is-super-admin'))
        if(auth('api')->user()->type!='super_admin'){
            return response()->json([
                'message' => "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }

        $user = User::findOrFail($id);
        //delete the user
        $user->delete();
        return response()->json(['message'=> 'user deleted', 'user'=>$user]);
    }
}
