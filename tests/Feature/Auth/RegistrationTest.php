<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class RegistrationTest extends TestCase
{

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_company_register()
    {
        $response = $this->get('/company-register');
        if ($response->status() == 302) {
            $response = $this->followRedirects($response);
        }
        $response->assertViewIs('auth.register-company');
    }
}
