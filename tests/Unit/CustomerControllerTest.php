<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Http\Controllers\API\CustomerController;

class CustomerControllerTest extends TestCase
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

        $controller = new CustomerController();
        $response = $controller->index($boutiqueId);
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testCreateCustomer()
    {
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la nouvelle commande à créer
        $brandDataLocal = [
            'store'=>$boutiqueIdLocal,
            'first_name'=>'Nazarette',
            'last_name'=>'Hadj',
            'email'=>'nazarette@gmail.com',
            'telephone'=>'0201023669',
            'country'=>'MA',
            'ville'=>'Marrakech',
            'adresse'=>'avenu 5',
        ];
        $brandDataWoocommerce = [
            'store'=>$boutiqueIdWoocommerce,
            'first_name'=>'Nazarette',
            'last_name'=>'Hadj',
            'email'=>'nazarette@gmail.com',
            'telephone'=>'0604020336',
            'country'=>'MA',
            'adresse'=>'Marrakech',
            'motdepasse' => '12345678',
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new CustomerController();
        // $response = $controller->store(new Request($brandDataLocal));
        $response = $controller->store(new Request($brandDataWoocommerce));
        // $response = $this->post('/api/product', $productData);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testUpdateCustomer()
    {
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la nouvelle commande à créer
        $brandDataLocal = [
            'store'=>$boutiqueIdLocal,
            'first_name'=>'Phenix',
            'last_name'=>'Kadia',
            'email'=>'kadia@gmail.com',
            'telephone'=>'0201023669',
            'country'=>'MA',
            'ville'=>'Casablanca',
            'adresse'=>'avenu 89',
        ];
        $brandDataWoocommerce = [
            'store'=>$boutiqueIdWoocommerce,
            'first_name'=>'Phenix',
            'last_name'=>'Kadia',
            'email'=>'kadia@gmail.com',
            'telephone'=>'0201023669',
            'country'=>'MA',
            'adresse'=>'avenu 89',
            'motdepasse' => 'kadia1234556',
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "store" de ProductController
        $controller = new CustomerController();
        $response = $controller->update(new Request($brandDataLocal),46);
        // $response = $controller->update(new Request($brandDataWoocommerce),439);
        // $response = $this->post('/api/product', $productData);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testDeleteCustomer()
    {
        //  Recuperer la boutique à supprimer
        $customerIdLocal = 47;
        $customerIdWooCommerce = 40;
        $controller = new CustomerController();
        //Suppression pour la boutique local
        $response = $controller->destroy(1,$customerIdLocal);
        //Suppression pour la boutique Woocommerce
        // $response = $controller->destroy(4,$customerIdWooCommerce);
        // Vérifiez que la suppression a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
}
