<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Controllers\API\FactureController;

class FactureControllerTest extends TestCase
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
    public function testUpdateStatutFacture()
    {
        $boutiqueLocal = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueIdLocal = $boutiqueLocal->id;
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        // Données de la  Facture à modifier
        $factureDataLocal = [
            'store' => $boutiqueIdLocal,
            'status' => 'ferme',
        ];
        $factureDataWoocommerce = [
            'store' => $boutiqueIdWoocommerce,
            'status' => 'ouvert',
        ];
        // dd($orderData);
        // Effectuez l'appel à la méthode "update" de FactureController
        $controller = new FactureController();
        $response = $controller->update(new Request($factureDataLocal),35);
        // $response = $controller->update(new Request($factureDataWoocommerce),23);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testSendMailFacture()
    {
        $factureData= [
            'email' => 'mc67631685@gmail.com',
        ];
        // Effectuez l'appel à la méthode "sendMail" de FactureController
        $controller = new FactureController();
        $response = $controller->sendMail(new Request($factureData),29);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testGetProcessFactures()
    {
        //Boutique Woocommerce
        $boutiqueId=4;
       //Boutique Local
        // $boutiqueId=1;

        $controller = new FactureController();
        $response = $controller->getProcessFactures($boutiqueId);
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testCreateProcessFacture()
    {
        $boutiqueWoocommerce = Boutique::where('store_url', 'https://miimstore.com')->first();
        $boutiqueIdWoocommerce = $boutiqueWoocommerce->id;
        $factureData= [
            'order_id' => 4819,
            'store' =>  $boutiqueIdWoocommerce,    
        ];
 
        // Effectuez l'appel à la méthode "createProcessFacture" de FactureController
        $controller = new FactureController();
        $response = $controller->createProcessFacture(new Request($factureData));

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testExportProcessFacture()
    {
        // Effectuez l'appel à la méthode "exportProcessFacture" de FactureController
        $controller = new FactureController();
        $response = $controller->exportProcessFacture(52);

        // Assurez-vous que la création de la commande a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
}
