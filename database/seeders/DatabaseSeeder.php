<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //insert data to boutique_types table using db query
        /*try{
            DB::beginTransaction();


            DB::table('boutique_types')->insert([
                ['name' => 'Local','icon'=>'local.png'],
                ['name' => 'Woocommerce','icon' => 'woocommerce.png'],
                ['name' => 'Shopify','icon' => 'shopify.png'],
            ]);    
    
            //insert data to boutiques table using db query
            DB::table('boutiques')->insert([
                [
                'store_url' => 'https://www.google.com',
                'consumer_key' => 'ck_0e0e0e0e0e0e0e0e0e0e0e0e0e',
                'consumer_secret' => 'cs_0e0e0e0e0e0e0e0e0e0e0e0e0e',
                'user_id' => 1,
                'type_id' => 1,
                ],
                [
                    'store_url' => 'https://www.woocommerce.com',
                    'consumer_key' => 'ck_0e0e0e0e0e0e0e0e0e0e0e0e0e',
                    'consumer_secret' => 'cs_0e0e0e0e0e0e0e0e0e0e0e0e0e',
                    'user_id' => 1,
                    'type_id' => 2,
                ],
    
            ]);
            //insert data to categories table using db query
            DB::table('categories')->insert([
                ['nom' => 'Telephones','boutique_id' =>1],
                ['nom' => 'Ordinateurs','boutique_id' =>1],
                ['nom' => 'Electromenagers','boutique_id' =>1],
                ['nom' => 'Vetements','boutique_id' =>1],
                ['nom' => 'Autres','boutique_id' =>1],
            ]);
    
            //insert data to produits table using db query,well produit structure {nom,description,sku,permalien,stock_status,pub_status,quantite,prix,boutique_id}
            DB::table('produits')->insert([
                ['nom' => 'Iphone6','description' => 'Iphone6','sku' => 'Iphone6','permalien' => 'Iphone6','stock_status' => 'instock','pub_status' => 'publish','quantite' => 1,'prix' => 1000],
                ['nom' => 'mac os','description' => 'mac os','sku' => 'mac os','permalien' => 'mac os','stock_status' => 'instock','pub_status' => 'publish','quantite' => 1,'prix' => 1000],
                ['nom' => 'machine a laver','description' => 'machine a laver','sku' => 'machine a laver','permalien' => 'machine a laver','stock_status' => 'instock','pub_status' => 'publish','quantite' => 1,'prix' => 1000],
                ['nom' => 'chemise','description' => 'chemise','sku' => 'chemise','permalien' => 'chemise','stock_status' => 'instock','pub_status' => 'publish','quantite' => 1,'prix' => 1000],
                ['nom' => 'sac','description' => 'sac','sku' => 'sac','permalien' => 'sac','stock_status' => 'instock','pub_status' => 'publish','quantite' => 1,'prix' => 1000],
            ]);
    
            //insert data to pivot table produit_categorie using db query
            DB::table('produit_categorie')->insert([
                ['produit_id' => 1,'categorie_id' => 1],
                ['produit_id' => 2,'categorie_id' => 6],
                ['produit_id' => 5,'categorie_id' => 7],
    
            ]);
    
            //insert clients
            DB::table('clients')->insert([
                ['prenom' => 'client1','nom' => 'client1','email' => 'client1@gmail.com','telephone' => '0606060606','adresse' => 'hhhhhhh','pays'=>'MA','boutique_id' => 1],
                ['prenom' => 'client2','nom' => 'client2','email' => 'client2@gmail.com','telephone' => '0606060606','adresse' => 'hhhhhhh','pays'=>'MA','boutique_id' => 1],
            ]);
            //insert commandes
            DB::table('commandes')->insert([
                ['total' => 1000,'client_id' => 1],
                ['total' => 1000,'client_id' => 2],
                ['total' => 5000,'client_id' => 1],
                ['total' => 5000,'client_id' => 2],
            ]);
    
            //insert data to pivot table commande_produit using db query
            DB::table('commande_produit')->insert([
                ['commande_id' => 1,'produit_id' => 1,'quantite' => 50],
                ['commande_id' => 1,'produit_id' => 2,'quantite' => 40],
                ['commande_id' => 2,'produit_id' => 3,'quantite' => 30],
                ['commande_id' => 2,'produit_id' => 4,'quantite' => 20],
                ['commande_id' => 1,'produit_id' => 5,'quantite' => 20],
            ]);
            DB::commit();
            
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }*/

    }
}
