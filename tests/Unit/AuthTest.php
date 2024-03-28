<?php

namespace Tests\Unit;

use App\Http\Controllers\API\BoutiqueController;
use Tests\TestCase;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\assertTrue;
use App\Http\Controllers\API\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserAuthentication()
    {
        $user = User::where('email', 'mariamcoulibaly@gmail.com')->first();

        // Effectuez une demande HTTP pour l'authentification
        $response = $this->post('/login', [
            'email' => 'mariamcoulibaly@gmail.com',
            'password' => '12345678',
        ]);
        // $response = $this->post('/login', [
        //     'email' => 'mc@gmail.com',
        //     'password' => '12345678',
        // ]);
        // Assurez-vous que l'utilisateur est redirigé après l'authentification
        $response->assertRedirect('/home'); // Assurez-vous d'ajuster cette URL selon votre configuration.

        // Vérifiez que l'utilisateur est authentifié
        $this->assertAuthenticatedAs($user);
    }

    public function testUserLogout()
    {
        // Effectuez une demande HTTP pour la déconnexion
        $response = $this->post('/logout');

        // Assurez-vous que l'utilisateur est redirigé après la déconnexion
        $response->assertRedirect('/'); 
        // Vérifiez que l'utilisateur n'est plus authentifié
        $this->assertGuest();
    }
    
    // public function test_example()
    // {
    //     $this->assertTrue(true);
    // }
    // public function test_login_form(){
    //     $response = $this->get('/login');
    //     $response -> assertStatus(200);
    // }
    // public function test_user_duplication(){
    //     //Nous allons nous assurer que l'utilisateur ne peut pas creer le meme nom ni email
    //     $user1 = User::make([
    //         'name' => 'Koudedia',
    //         'email'=> 'koudedia@gmail.com',
    //     ]);
    //     $user2 = User::make([
    //         'name' => 'Mariam',
    //         'email'=> 'mariam@gmail.com',
    //     ]);

    //     $this->assertTrue($user1->email != $user2->email);
    // }
    // public function test_delete_user(){
    //     $user = User::make([
    //         'name' => 'Mariam',
    //         'email'=> 'mariam@gmail.com',
    //     ]);
    //     $response->assertRedirect('/home');
    // }
    // public function testUserControllerIndex()
    // {
    //       // Créez un utilisateur fictif avec l'usine et authentifiez-le
    //     $user = User::factory()->create([
    //         'name' => 'mariam',
    //         'email' => 'mariam@gmail.com',
    //         'password' => '12345678',
    //         'type' => 'super_admin',
    //     ]);

    //     Auth::login($user, true);

    //     // Maintenant, votre utilisateur est authentifié pour ce test
    //     $controller = new UserController();
    //     $response = $controller->index();

    //     $this->assertEquals(200, $response->getStatusCode());
    // }
}
