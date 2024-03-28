<?php

namespace App\Http\Controllers\API\Local;

use App\Http\Controllers\Controller;
use App\Imports\ImportClient;
use App\Models\Boutique;
use App\Models\Client;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($store)
    {
        try {
            // Récupérer les clients de la boutique
            $boutique = Boutique::where('id', $store)->with('clients')->firstOrFail();
            $clients = $boutique->clients;
    
            // Mise à jour de is_blacklisted dans la base de données
            foreach ($clients as $client) {
                $cancelledOrdersCount = Commande::where('client_id', $client['id'])
                    ->where('status', 'canceled')
                    ->count();
    
                $isBlacklisted = $cancelledOrdersCount >= 3;
    
                // Mettre à jour la base de données
                $clientModel = Client::findOrFail($client['id']);
                $clientModel->update([
                    'is_blacklisted' => $isBlacklisted,
                ]);
            }
    
            // Rafraîchir les données des clients dans la relation Eloquent
            $boutique->load('clients');
    
            // Récupérer à nouveau les clients après la mise à jour
            $clients = $boutique->clients->map(function ($item, $key) {
                return [
                    'id' => $item['id'],
                    'email' => $item['email'],
                    'date_created' => $item['created_at'],
                    'first_name' => $item['prenom'],
                    'last_name' => $item['nom'],
                    'billing' => [
                        'first_name' => $item['prenom'],
                        'last_name' => $item['nom'],
                        'country' => $item['pays'],
                        'address_1' => $item['adresse'],
                        'phone' => $item['telephone'],
                    ],
                    'isBlacklisted' => $item['is_blacklisted'],
                ];
            });
    
            return response()->json($clients, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Boutique not found!', 'erreur' => $e->getMessage()], 404);
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
        //
        $boutique = Boutique::where('id',$request->store)->firstOrFail();
        $client = $boutique->clients()->create([
            'nom' => $request->last_name,
            'prenom' => $request->first_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'pays' => $request->country,
            'ville' => $request->ville,
            'boutique_id' => $boutique->id,
        ]);
        return response()->json($client,200);
    }

    /**
     * import excel file
     */

    public function import(Request $request){
        
        try{
            //BEGIN TRANSACTION
            DB::beginTransaction();
            //insert data
            $data = $request->data;    
            //length of data array must be > 0
            if(!count($data))
                return response()->json(['error'=>'Data is empty'],422);
            //data length > 0
            $errors = [];
            foreach($data as $row){
                try{
                        //search client by email
                        $client = Client::where('email',$row['email'])->first();
                        //if client not found create new one
                        if($client)
                            throw new \Exception('Client with email '.$row['email'].' already exists');
                        
                        //create new client
                        Client::Create([
                            'nom' => $row['nom'],
                            'prenom' => $row['prenom'],
                            'email' => $row['email'],
                            'telephone' => $row['telephone'],
                            'adresse' => $row['adresse'],
                            'pays' => $row['pays'],
                            'boutique_id' => $request->store,
                        ]);

                }catch(\Exception $e){
                        $errors[] = $e->getMessage();
                }   
            }

            if(count($errors) > 0){
                DB::rollback();
                return response()->json(['errors' => $errors],422);
            }
            
            DB::commit();
            return response()->json(['success'=>'Data is successfully added'],200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['error'=>$e->getMessage()],422);
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
    public function update(Request $request, $customer_id)
    {
        //
        $boutique = Boutique::where('id',$request->store)->with('clients')->firstOrFail();
        $client = $boutique->clients()->where('id',$customer_id)->firstOrFail();
        $client->update([
            'nom' => $request->last_name,
            'prenom' => $request->first_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'pays' => $request->country,
        ]);

        return response()->json($client,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($store,$customer_id)
    {
        //
        $boutique = Boutique::where('id',$store)->with('clients')->firstOrFail();
        $client = $boutique->clients()->where('id',$customer_id)->firstOrFail();
        $client->delete();
        return response()->json(['message' => 'Client supprimé avec succès'],200);
    }
}
