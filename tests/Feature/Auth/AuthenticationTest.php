<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::first();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_logout()
    {
        $usuario = User::first();
        $response = $this->actingAs($usuario)
            ->get('logout');
        if ($response->status() == 302) {
            $response = $this->followRedirects($response);
        }
        $response->assertViewIs('auth.login');
    }
}
