<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\TransactionController;

class TransactionControllerTest extends TestCase
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
        //Boutique Woocommerce
        // $boutiqueId=2;

       //Boutique Local
        $boutiqueId=1;

        $controller = new TransactionController();
        $response = $controller->index($boutiqueId);
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testCreateTransaction()
    {
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la nouvelle commande à créer
        $transactionDataLocal = [
            'fournisseur_id' => 3,
            'marque_id' => 4,
            'boutique_id' => $boutiqueIdLocal,
            'produit_id' => 1,
            'quantite' => 10,
            'prix' => 100,
            'total' => 1000,
            'produit_name' => 'Iphone6',
        ];
        $transactionDataWoocommerce = [
            'fournisseur_id' => 4,
            'marque_id' => 2,
            'boutique_id' => $boutiqueIdWoocommerce,
            'produit_id' => 4122,
            'quantite' => 2,
            'prix' => 100,
            'total' => 1000,
            'produit_name' => 'Combinaison plissée',
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new TransactionController();
        $response = $controller->store(new Request($transactionDataLocal));
        // $response = $controller->store(new Request($transactionDataWoocommerce));
        // $response = $this->post('/api/product', $productData);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testUpdateQuantiteStock()
    {
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la nouvelle commande à créer
        $transactionDataLocal = [
            'store' => $boutiqueIdLocal,
            'produit_id' => 1,
            'quantite' => 10,
        ];
        $transactionDataWoocommerce = [
            'store' => $boutiqueIdWoocommerce,
            'produit_id' => 4122,
            'quantite' => 2,
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new TransactionController();
        // $response = $controller->updateQuantite(new Request($transactionDataLocal));
        $response = $controller->updateQuantite(new Request($transactionDataWoocommerce));
        // $response = $this->post('/api/product', $productData);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testUpdateTransaction()
    {
       
        // Données de la nouvelle commande à créer
        $transactionDataLocal = [
            'visible' => 0,
        ];
        $transactionDataWoocommerce = [
            'visible' => 0,
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new TransactionController();
        $response = $controller->update(new Request($transactionDataLocal),40);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
}
