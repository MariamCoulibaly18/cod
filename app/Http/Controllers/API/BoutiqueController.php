<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Providers\WooCommerceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BoutiqueController extends Controller
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
        //if its admin return just its boutique , but super_admin return all
        // if(Gate::allows('is-super-admin'))
        if(auth('api')->user()->type=='super_admin'){
        
            $boutiques=Boutique::latest()->with('type')->with('user')->get();
            return response()->json(['data' => $boutiques]);


        }else if(auth('api')->user()->type=='admin'){
            $boutiques=Boutique::where('user_id',auth('api')->user()->id)->latest()->with('type')->with('user')->get();
            return response()->json(['data' => $boutiques]);
        }else{
            
            return response()->json([
                'message' => "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }
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
                'message' => "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }


        $this->validate($request,[
            'name'=>'required|string|max:191',
            'store_url'=>'required|string|max:191',
            'consumer_key'=>'required|string|max:191',
            'consumer_secret'=>'required|string|max:191',
            'type.id'=>'integer',
            'user.id'=>'integer',
            // 'type.id'=>'required|integer',
            // 'user.id'=>'required|integer',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validation pour le logo (image)
        ]);

        $boutique =Boutique::create([
            'name'=> $request['name'],
            'store_url'=> $request['store_url'],
            'consumer_key'=> $request['consumer_key'],
            'consumer_secret'=> $request['consumer_secret'],
            'type_id'=> $request['type.id'],
            'user_id'=> $request['user.id'],
        ]);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $fileName = $request['name'] . '.' . $extension;
            $file->move(public_path('/images/logoSite/'), $fileName);
    
            // Enregistrez le nom du fichier dans la base de données
            $boutique->logo = $fileName;
        }
        $boutique->save();
        return response()->json($boutique,201);
    }
    // public function store(Request $request)
    // {
    //     //allow only super admin to create user
    //     // if(!Gate::allows('is-super-admin'))
    //     if(!auth('api')->user()->type=='super_admin'){
    //         return response()->json([
    //             'message' => "Vous n'êtes pas autorisé à accéder à cette ressource",
    //         ], 403);
    //     }


    //     $this->validate($request,[
    //         'name'=>'required|string|max:191',
    //         'store_url'=>'required|string|max:191',
    //         'consumer_key'=>'required|string|max:191',
    //         'consumer_secret'=>'required|string|max:191',
    //         'type.id'=>'integer',
    //         'user.id'=>'integer',
    //         // 'type.id'=>'required|integer',
    //         // 'user.id'=>'required|integer',
    //         'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validation pour le logo (image)
    //     ]);
    //     $name = $request->name;
    //     $store_url = $request->store_url;
    //     $consumer_key = $request->consumer_key;
    //     $consumer_secret = $request->consumer_secret;
    //     $type_id = $request->type_id;
    //     $user_id = $request->user_id;
    //     // Vérifiez si une image a été téléchargée
    //     if ($request->hasFile('logo')) {
    //         // Utilisez Cloudder pour télécharger l'image vers Cloudinary
    //         Cloudder::upload($request->file('logo')->getRealPath(), null);
            
    //         // Récupérez l'URL de l'image depuis Cloudinary
    //         $logo = Cloudder::getResult()['url'];
    //     }
    //     $boutique =Boutique::create([
    //         'name'=> $name,
    //         'store_url'=> $store_url,
    //         'consumer_key'=> $consumer_key,
    //         'consumer_secret'=> $consumer_secret,
    //         'type_id'=> $type_id,
    //         'user_id'=> $user_id,
    //         'logo'=> $logo,
    //     ]);
    //     $boutique->save();
    //     return response()->json($boutique,201);
    // }
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
     * Test la connection avec la boutique (juste pour les boutiques non local)
     */
    public function connect($store){

        $boutique = Boutique::where('id', $store)->with('type')->firstOrFail();
        //allow only super admin or responsible of the store to connect to the store
        // if(!Gate::allows('is-super-admin') && !Gate::allows('is-responsible',$boutique))
        if(auth('api')->user()->type!='super_admin' && auth('api')->user()->type!='admin'){
            return response()->json([
                'message' => "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }

        //if local store
        if($boutique->type['name'] == 'Local'){
            return response()->json(['message' => "Il s'agit d'une boutique local"], 422);
        }


        //if woocommerce store
        if($boutique->type['name'] == 'Woocommerce'){            
            try{
                
                $woocommerce = WooCommerceService::getClient($boutique->store_url, $boutique->consumer_key, $boutique->consumer_secret);
                $response =  $woocommerce->get('system_status');
                $response = json_decode(json_encode($response), true);           
               
                if($response['environment']['remote_get_successful'] != true){
                    throw new \Exception("Ce n'est pas une boutique WooCommerce valide");
                }
            }catch(\Exception $e){
                return response()->json(['error' => "Ce n'est pas une boutique WooCommerce valide"], $e->getCode());
            }  
            // $visits = $woocommerce->get('reports/visits');
            // dd($visits);
            // // Récupérer le nombre total de ventes
            // $sales = $woocommerce->get('reports/sales');
            // // Vous pouvez accéder aux données de visite et de vente à partir des réponses.
            // $visitsCount = $visits['total'];
            // $salesCount = $sales['total'];
            return response()->json(['message' => "C'est une boutique WooCommerce valide"], 200);
        }


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
        $boutique = Boutique::findOrFail($id);
        //allow only super admin or responsible of the store to connect to the store
        // if(!Gate::allows('is-super-admin') && !Gate::allows('is-responsible',$boutique))
        if(!auth('api')->user()->type=='super_admin' && !auth('api')->user()->type=='admin'){
            return response()->json([
                'message' => "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }

        if(Gate::allows('is-responsible',$boutique)){
            $request['user.id'] = auth()->user()->id;
        }
        
        //validate the request
        $this->validate($request,[
            'name'=>'string|max:191',
            'store_url'=>'string|max:191',
            'consumer_key'=>'string|max:191',
            'consumer_secret'=>'string|max:191',
            'type.id'=>'integer',
            'user.id'=>'integer',
            // 'logo' => '', // Validation pour le logo (image)
        ]);

        // dd($boutique);

        $boutique->name = $request['name'];
        $boutique->store_url = $request['store_url'];
        $boutique->consumer_key = $request['consumer_key'];
        $boutique->consumer_secret = $request['consumer_secret'];
        $boutique->type_id = $request['type.id'];
        $boutique->user_id = $request['user.id'];
        // dd($request->hasFile('logo'));
        // // Mettez à jour le logo uniquement si un nouveau logo a été téléchargé.
        // if ($request->hasFile('logo')) {
        //     $logoPath = $request->file('logo')->store('logos', 'public'); // Stockage de la nouvelle image
        //     $boutique->logo = $logoPath;
        // }
        $boutique->save();
        return ['message'=>'Boutique mise à jour avec succès', 'boutique'=>$boutique];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //allow only super admin or responsible of the store to connect to the store
        // if(!Gate::allows('is-super-admin'))
        if(!auth('api')->user()->type='super_admin'){
            return response()->json([
                'message' => "Vous n'êtes pas autorisé à accéder à cette ressource",
            ], 403);
        }
        //
        $boutique = Boutique::findOrFail($id);
        $boutique->delete();
        return response()->json(['message'=>'Boutique supprimée avec succès']);
    }
}
