<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Models\User;
use App\Models\Boutique;
use App\Http\Controllers\API\BoutiqueController;

class BoutiqueControllerTest extends TestCase
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
    public function testViewBoutiquesBySuperAdmin()
    {
        
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
        // $admin = User::where('email', 'mc67631685@gmail.com')->first();
        // $livreur = User::where('email', 'mariam@gmail.com')->first();

        // Authentifiez l'utilisateur
        $this->actingAs($superAdmin, 'api');
        // $this->actingAs($admin, 'api');
        // $this->actingAs($livreur, 'api');
        $controller = new BoutiqueController();
        $response = $controller->index();
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testCreateBoutiqueBySuperAdmin()
    {
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
 
        // Authentifiez l'utilisateur super admin
        $this->actingAs($superAdmin, 'api');
        
        // Données de la nouvelle boutique à créer
        $boutiqueData = [
            'name' => 'Test',
            'store_url' => 'test.com',
            'consumer_key' => 'abcd45678',
            'consumer_secret' => '123efghs',
            'type.id' => 1, 
            'user.id' => 2,

        ];
        // dd($boutiqueData);
        // Effectuez l'appel à la méthode "store" de BoutiqueController
        // $response = $this->json('POST', '/api/user', $userData);
        $response =$this->post('/api/boutique', $boutiqueData);
        // Assurez-vous que la création de la boutique a réussi
        $response->assertStatus(201);

        // Vérifiez que la boutique a été ajouté à la base de données
        $this->assertDatabaseHas('boutiques', [
            'name' => 'Test',
            'store_url' => 'test.com',
            'consumer_key' => 'abcd45678',
            'consumer_secret' => '123efghs',
        ]);
    }
    public function testUpdateBoutiqueBySuperAdmin()
    {
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
        $boutiqueToUpdate = Boutique::where('store_url', 'test.com')->first();
        $boutiqueId = $boutiqueToUpdate->id;
        // Authentifiez l'utilisateur super admin
        $this->actingAs($superAdmin, 'api');
        
        // Données de la nouvelle boutique à créer
        $boutiqueData = [
            'name' => 'Test',
            'store_url' => 'test12.com',
            'consumer_key' => 'abcd45678',
            'consumer_secret' => '123efghs',
            'type.id' => 1, 
            'user.id' => 2,

        ];
        // Effectuez l'appel à la méthode "store" de BoutiqueController
        // $response = $this->json('POST', '/api/user', $userData);
        $response =$this->put('/api/boutique/'.$boutiqueId, $boutiqueData);
        // Assurez-vous que la création de la boutique a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testDeleteBoutique()
    {
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
        // $user = User::where('email', 'mariam@gmail.com')->first();
        //  Recuperer la boutique à supprimer
        $boutiqueToDelete = Boutique::where('store_url', 'test.com')->first();
        // Authentifiez l'utilisateur super admin
        $this->actingAs($superAdmin, 'api');
        // $this->actingAs($user, 'api');
        $controller = new BoutiqueController();
        $response = $controller->destroy($boutiqueToDelete->id);
        // Vérifiez que la suppression a réussi
        $this->assertEquals(200, $response->getStatusCode());

        // Vérifiez que la boutique a été supprimé de la base de données
        $this->assertDatabaseMissing('boutiques', [
            'id' => $boutiqueToDelete->id,
        ]);
    }
    public function testConnectBoutique()
    {
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
        // $admin = User::where('email', 'mc67631685@gmail.com')->first();
        // $livreur = User::where('email', 'mariam@gmail.com')->first();

        // $user = User::where('email', 'mariam@gmail.com')->first();
        //  Recuperer la boutique à supprimer
        // $boutiqueToConnect = Boutique::where('store_url', 'https://www.google.com')->first();
        $boutiqueToConnect = Boutique::where('store_url', 'test12.com')->first();
        // Authentifiez l'utilisateur super admin
        $this->actingAs($superAdmin, 'api');
        // $this->actingAs($user, 'api');
        $controller = new BoutiqueController();
        $response = $controller->connect($boutiqueToConnect->id);
        // Vérifiez que la suppression a réussi
        $this->assertTrue($response->getStatusCode() === 422 || $response->getStatusCode() === 200);
    }

}
