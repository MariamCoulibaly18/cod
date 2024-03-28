<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BrandController;

class BrandControllerTest extends TestCase
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
        // $boutiqueId=4;

       //Boutique Local
        $boutiqueId=1;

        $controller = new BrandController();
        $response = $controller->index($boutiqueId);
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testCreateBrand()
    {
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la nouvelle commande à créer
        $brandDataLocal = [
            'name' => 'Toyota',
            'description' => 'Toyota',
            'store' =>  $boutiqueIdLocal,

        ];
        $brandDataWoocommerce = [
            'name' => 'Toyota',
            'store' =>  $boutiqueIdWoocommerce,
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new BrandController();
        $response = $controller->store(new Request($brandDataLocal));
        // $response = $controller->store(new Request($brandDataWoocommerce));
        // $response = $this->post('/api/product', $productData);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testUpdateBrand()
    {
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la nouvelle commande à créer
        $brandDataLocal = [
            'name' => 'Mercedes',
            'description' => 'Mercedes',
            'store' =>  $boutiqueIdLocal,

        ];
        $brandDataWoocommerce = [
            'name' => 'Mercedes',
            'store' =>  $boutiqueIdWoocommerce,
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new BrandController();
        // $response = $controller->update(new Request($brandDataLocal),14);
        $response = $controller->update(new Request($brandDataWoocommerce),290);
        // $response = $this->post('/api/product', $productData);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testDeleteBrand()
    {
        //  Recuperer la boutique à supprimer
        $brandIdLocal = 14;
        $brandIdWooCommerce = 290;
        $controller = new BrandController();
        //Suppression pour la boutique local
        $response = $controller->destroy(1,$brandIdLocal);
        //Suppression pour la boutique Woocommerce
        // $response = $controller->destroy(4,$brandIdWooCommerce);
        // Vérifiez que la suppression a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
}
