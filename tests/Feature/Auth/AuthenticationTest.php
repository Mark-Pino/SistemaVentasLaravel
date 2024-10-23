<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        // Crea un usuario con un nombre de usuario y contraseña
        $user = User::factory()->create([
            'username' => 'testuser', // Asegúrate de que se establezca un nombre de usuario
            'password' => bcrypt('password'), // Asegúrate de que esta contraseña coincida
        ]);

        // Realiza el login usando username y password
        $response = $this->post('/login', [
            'username' => $user->username, // Utiliza el nombre de usuario en la solicitud
            'password' => 'password', // La contraseña debe coincidir
        ]);

        // Asegúrate de que el usuario esté autenticado
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }




    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
