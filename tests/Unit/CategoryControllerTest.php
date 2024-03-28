<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\API\CategoryController;

class CategoryControllerTest extends TestCase
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
        
        // $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
        $admin = User::where('email', 'mc67631685@gmail.com')->first();
        // $livreur = User::where('email', 'mariam@gmail.com')->first();

        //Boutique Woocommerce
        $boutiqueId=4;

       //Boutique Local
        // $boutiqueId=1;
        // Authentifiez l'utilisateur
        // $this->actingAs($superAdmin, 'api');
        $this->actingAs($admin, 'api');
        // $this->actingAs($livreur, 'api');
        $controller = new CategoryController();
        $response = $controller->index($boutiqueId);
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testCreateCategory()
    {
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la nouvelle commande à créer
        $categoryDataLocal = [
            'name' => 'Vernis',
            'store' =>  $boutiqueIdLocal,

        ];
        $categoryDataWoocommerce = [
            'name' => 'Vernis',
            'store' =>  $boutiqueIdWoocommerce,
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new CategoryController();
        // $response = $controller->store(new Request($categoryDataLocal));
        $response = $controller->store(new Request($categoryDataWoocommerce));
        // $response = $this->post('/api/product', $productData);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testUpdateCategory()
    {
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la nouvelle commande à créer
        $categoryDataLocal = [
            'name' => 'Vetrines',
            'store' =>  $boutiqueIdLocal,

        ];
        $categoryDataWoocommerce = [
            'name' => 'Vetrines',
            'store' =>  $boutiqueIdWoocommerce,
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new CategoryController();
        $response = $controller->update(new Request($categoryDataLocal),8);
        // $response = $controller->update(new Request($categoryDataWoocommerce),289);
        // $response = $this->post('/api/product', $productData);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testDeleteCategory()
    {
        //  Recuperer la boutique à supprimer
        $categoryIdLocal = 16;
        $categoryIdWooCommerce = 289;
        $controller = new CategoryController();
        //Suppression pour la boutique local
        $response = $controller->destroy(1,$categoryIdLocal);
        //Suppression pour la boutique Woocommerce
        // $response = $controller->destroy(4,$categoryIdWooCommerce);
        // Vérifiez que la suppression a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
}
