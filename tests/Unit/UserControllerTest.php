<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\API\UserController;

class UserControllerTest extends TestCase
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
    public function testViewUsersBySuperAdmin()
    {
        
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
        // $user = User::where('email', 'mariam@gmail.com')->first();
        // Authentifiez l'utilisateur super admin
        $this->actingAs($superAdmin, 'api');

        $controller = new UserController();
        $response = $controller->index();
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testCreateUserBySuperAdmin()
    {
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
 
        // Authentifiez l'utilisateur super admin
        $this->actingAs($superAdmin, 'api');
        // Données du nouvel utilisateur à créer
        $userData = [
            'name' => 'Mohamed kone',
            'email' => 'mohamed@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'type' => 'admin',
        ];

        // Effectuez l'appel à la méthode "store" de UserController
        // $response = $this->json('POST', '/api/user', $userData);
        $response =$this->post('/api/user', $userData);
        // Assurez-vous que la création de l'utilisateur a réussi
        $response->assertStatus(201);

        // Vérifiez que l'utilisateur a été ajouté à la base de données
        $this->assertDatabaseHas('users', [
            'name' => 'Mohamed kone',
            'email' => 'mohamed@gmail.com',
            'type' => 'admin',
        ]);
        //   // Créez un utilisateur fictif avec l'usine et authentifiez-le
        //   $user = User::factory()->create([
        //     'name' => 'mariam',
        //     'email' => 'mariam@gmail.com',
        //     'password' => '12345678',
        //     'type' => 'super_admin',
        // ]);

        // Auth::login($user, true);

        // // Maintenant, votre utilisateur est authentifié pour ce test
        // $controller = new UserController();
        // $response = $controller->index();

        // $this->assertEquals(200, $response->getStatusCode());
    }
    public function testUpdateUserBySuperAdmin()
    {
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
        $UserToUpdate = User::where('email', 'mohamed@gmail.com')->first();
        $userId = $UserToUpdate->id;
        // Authentifiez l'utilisateur super admin
        $this->actingAs($superAdmin, 'api');
        
        // Données de la nouvelle boutique à créer
        $userData = [
            'name' => 'Mohamed Tall',
            'email' => 'mohamed@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'type' => 'livreur',

        ];
        // Effectuez l'appel à la méthode "store" de BoutiqueController
        // $response = $this->json('POST', '/api/user', $userData);
        $response =$this->put('/api/user/'.$userId, $userData);
        // Assurez-vous que la création de la boutique a réussi
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testDeleteUser()
    {
        $superAdmin = User::where('email', 'mariamcoulibaly@gmail.com')->first();
        // $admin = User::where('email', 'mc67631685@gmail.com')->first();
        // $livreur = User::where('email', 'mariam@gmail.com')->first();
        // Créez un utilisateur à supprimer
        $userToDelete = User::create([
            'name' => 'User to Delete',
            'email' => 'delete@example.com',
            'password' => bcrypt('password123'),
            'type' => 'livreur',
        ]);
        // Authentifiez l'utilisateur super admin
        $this->actingAs($superAdmin, 'api');

        // Effectuez une demande HTTP pour supprimer l'utilisateur
        // $response = $this->deleteJson("/api/users/{$userToDelete->id}");
        
        $controller = new UserController();
        $response = $controller->destroy($userToDelete->id);
        
        // Vérifiez que la suppression a réussi
        $this->assertEquals(200, $response->getStatusCode());

        // Vérifiez que l'utilisateur a été supprimé de la base de données
        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id,
        ]);
    }
}
