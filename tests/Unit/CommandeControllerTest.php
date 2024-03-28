<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Boutique;
use App\Http\Controllers\API\OrderController;

class CommandeControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    public function testIndex()
    {
        
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
        // $admin = User::where('email', 'mc67631685@gmail.com')->first();
        // $livreur = User::where('email', 'mariam@gmail.com')->first();

        //Boutique Woocommerce
        // $boutiqueId=4;

       //Boutique Local
        $boutiqueId=1;
        // Authentifiez l'utilisateur
        $this->actingAs($superAdmin, 'api');
        // $this->actingAs($admin, 'api');
        // $this->actingAs($livreur, 'api');
        $controller = new OrderController();
        $response = $controller->index($boutiqueId);
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testCreateCommande()
    {
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();

        // Authentifiez l'utilisateur super admin
        $this->actingAs($superAdmin, 'api');

        $client = Client::where('email', 'mc67631685@gmail.com')->first();
        $boutique = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueId = $boutique->id;

        // Récupérez tous les produits
        $products = Produit::where('nom', 'Iphone6')->get();
        $total = 0;

        // Calcul du total des produits
        foreach ($products as $product) {
            $total += $product->prix * $product->quantite;
        }

        // Construction des données pour la création de la commande cas d'une quantite normal
        $orderProducts = [];
        foreach ($products as $product) {
            $orderProducts[] = [
                'id' => $product->id,
                'quantity' => 2,
                'price' => $product->prix,
            ];
        }
        // Construction des données pour la création de la commande cas d'une quantite>au stock
        // $orderProducts = [];
        // foreach ($products as $product) {
        //     $orderProducts[] = [
        //         'id' => $product->id,
        //         'quantity' => 20,
        //         'price' => $product->prix,
        //     ];
        // }

        // Données de la nouvelle commande à créer
        $orderData = [
            'client' => $client->toArray(),
            'store' => $boutiqueId,
            'products' => $orderProducts, // Utilisez les données structurées des produits pour la commande
            'status' => 'on-hold',
            'total' => $total,
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de votre controller
        $response = $this->post('/api/order', $orderData);

        // Assurez-vous que la création de la commande a réussi
        $response->assertStatus(200);
    }
    public function testUpdateCommande()
    {
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
        $commandeIdLocal = 69;
        $commandeIdWooCommerce = 4636;
        $client = Client::where('email', 'client2@gmail.com')->first();
        $boutique = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueId = $boutique->id;

        // Récupérez tous les produits
        $products = Produit::where('nom', 'chemise')->get();
        $total = 0;

        // Calcul du total des produits
        $quantite=2;

        // Construction des données pour la création de la commande cas d'une quantite normal
        $orderProducts = [];
        foreach ($products as $product) {
            $total += $product->prix * $quantite;
            $orderProducts[] = [
                'id' => $product->id,
                'quantity' =>  $quantite,
                'price' => $product->prix,
            ];
        }
        // Authentifiez l'utilisateur super admin
        $this->actingAs($superAdmin, 'api');
        
        // Données de la nouvelle boutique à créer
        $orderDataLocal = [
            'client' => $client->toArray(),
            'store' => $boutiqueId,
            'products' => $orderProducts, // Utilisez les données structurées des produits pour la commande
            'status' => 'completed',
            'total' => $total,
        ];
        $orderDataWoocommerce= [
            'store' => 4,
            'status' => 'pending',
        ];
        // Effectuez l'appel à la méthode "store" de orderController/Local
        $response =$this->put('/api/order/'.$commandeIdLocal, $orderDataLocal);
        // Effectuez l'appel à la méthode "store" de orderController/Woocommerce
        // $response =$this->put('/api/order/'.$commandeIdWooCommerce, $orderDataWoocommerce);
        // Assurez-vous que la création de la boutique a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testDeleteCommande()
    {
        //  Recuperer la boutique à supprimer
        $commandeIdLocal = 94;
        $commandeIdWooCommerce = 4636;
        $controller = new OrderController();
        //Suppression pour la boutique local
        $response = $controller->destroy(1,$commandeIdLocal);
        //Suppression pour la boutique Woocommerce
        // $response = $controller->destroy(4,$commandeIdWooCommerce);
        // Vérifiez que la suppression a réussi
        $this->assertEquals(200, $response->getStatusCode());

        // Vérifiez que la boutique a été supprimé de la base de données
        $this->assertDatabaseMissing('commandes', [
            'id' => $commandeIdLocal,
        ]);
    }
    public function testupdateMultipleCommande()
    {
        $commandeIdsWooCommerce = [4636,4639,4631];
        $boutique = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueId = $boutique->id;
        // Authentifiez l'utilisateur super admin
        $orderDataWoocommerce = [
            'store' => $boutiqueId,
            'order_ids' => $commandeIdsWooCommerce,
            'status' => 'processing',
        ];
        
        // Effectuez l'appel à la méthode "store" de orderController/Woocommerce
        $response = $this->put('/api/orders/' . implode(',', $commandeIdsWooCommerce), $orderDataWoocommerce);
        // Assurez-vous que la création de la boutique a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testupdateStatutLivraison()
    {
        $commandeId = 12;
        $boutique = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueId = $boutique->id;
        // Authentifiez l'utilisateur super admin
        $orderDataLocal = [
            'store_id' => $boutiqueId,
            'statut_livraison_id' => 4,
        ];
        // Effectuez l'appel à la méthode "store" de orderController/Woocommerce
        $response = $this->put('/api/updateStatutLivraison/' . $commandeId, $orderDataLocal);
        // Assurez-vous que la création de la boutique a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testshowDetailsCommande()
    {
        $commandeIdLocal = 12;
        $commandeIdWoocommerce = 4636;
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        $controller = new OrderController();
        // Effectuez l'appel à la méthode "show" de orderController
        $response = $controller->show( $boutiqueIdLocal ,$commandeIdLocal);
        // $response = $controller->show( $boutiqueIdWoocommerce ,$commandeIdWoocommerce);

        // Voir si la création de la boutique a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }

}
