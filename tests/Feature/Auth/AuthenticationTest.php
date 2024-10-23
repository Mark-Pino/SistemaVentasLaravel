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

    // public function test_users_can_authenticate_using_the_login_screen(): void
    // {
    //     // Crea un usuario con email y contraseña
    //     $user = User::factory()->create([
    //         'email' => 'test@example.com', // Asegúrate de usar un correo
    //         'password' => bcrypt('password'), // Asegúrate de que esta contraseña coincida
    //     ]);

    //     // Realiza el login usando el correo y la contraseña
    //     $response = $this->post('/login', [
    //         'email' => $user->email, // Usa el campo email
    //         'password' => 'password', // La contraseña debe coincidir
    //     ]);

    //     // Asegúrate de que el usuario esté autenticado
    //     $this->assertAuthenticated();
    //     $response->assertRedirect(RouteServiceProvider::HOME);
    // }


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
