<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Auth\Concerns\CreateDefaultUser;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    use CreateDefaultUser;

    public function testRegistrationScreenCanBeRendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewUsersCanRegister()
    {
        $this->withoutExceptionHandling();

        $this->createDefaults();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'business' => 'Example, Inc.',
            'username' => 'TestUser',
            'email' => 'test@example.com',
            'password' => 'password',
            'type' => 'business',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
