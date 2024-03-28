<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Providers\WooCommerceService;
use App\Http\Controllers\API\ProductController;

class ProductControllerTest extends TestCase
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
       //Boutique Local
        $boutiqueLocalId=1;
        //Boutique Woocommerce
        $boutiqueWoocommerceId=4;
        // $this->actingAs($admin, 'api');
        // $this->actingAs($livreur, 'api');
        $controller = new ProductController();
        // $response = $controller->index($boutiqueLocalId);
        $response = $controller->index($boutiqueWoocommerceId);
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testCreateProduct()
    {
        // $client = Client::where('email', 'mc67631685@gmail.com')->first();
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la nouvelle commande à créer
        $productDataLocal = [
            'name' => 'Test',
            'description' => 'Test',
            'price' => 500,
            'sku' => 'test',
            'stock_quantity' => 0 ,
            'stock_status' => 'outofstock',
            'pub_status' => 'draft' ,
            'slug' => 'test',
            'categories' => [2,3],
            'brand' => 'Dell',
            'store' =>  $boutiqueIdLocal,

        ];
        $productDataWoocommerce = [
            'name' => 'Test',
            'description' => 'Test',
            'price' => 500,
            'sku' => 'test',
            'stock_quantity' => 0 ,
            'stock_status' => 'outofstock',
            'pub_status' => 'draft' ,
            'slug' => 'test',
            'categories' => [125,38,162],
            'brand' => 'Dell',
            'store' =>  $boutiqueIdWoocommerce,
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new ProductController();
        $response = $controller->store(new Request($productDataLocal));
        // $response = $controller->store(new Request($productDataWoocommerce));
        // $response = $this->post('/api/product', $productData);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testUpdateProduct()
    {
        // $client = Client::where('email', 'mc67631685@gmail.com')->first();
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la nouvelle commande à créer
        $productDataLocal = [
            'name' => 'Test236',
            'description' => 'Test',
            'price' => 1000,
            'sku' => 'test',
            'stock_quantity' => 90 ,
            'stock_status' => 'outofstock',
            'pub_status' => 'draft' ,
            'slug' => 'test',
            'categories' => [4,5],
            'brand' => 'Lenovo',
            'store' =>  $boutiqueIdLocal,

        ];
        $productDataWoocommerce = [
            'name' => 'Test',
            'description' => 'Test',
            'price' => 500,
            'sku' => 'test',
            'stock_quantity' => 0 ,
            'stock_status' => 'outofstock',
            'pub_status' => 'draft' ,
            'slug' => 'test',
            'categories' => [125,38,162],
            'brand' => 'Dell',
            'store' =>  $boutiqueIdWoocommerce,
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new ProductController();
        $response = $controller->update(new Request($productDataLocal),29);
        // $response = $controller->update(new Request($productDataWoocommerce),4817);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testDeleteProduct()
    {
        //  Recuperer la boutique à supprimer
        $productIdLocal = 31;
        $productIdWooCommerce = 4817;
        $controller = new ProductController();
        //Suppression pour la boutique local
        // $response = $controller->destroy(1,$productIdLocal);
        //Suppression pour la boutique Woocommerce
        $response = $controller->destroy(4,$productIdWooCommerce);
        // Vérifiez que la suppression a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
}
