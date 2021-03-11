<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\Business;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrationScreenCanBeRendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewBusinessUsersCanRegister()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'business' => 'Example, Inc.',
            'phone' => '0775018795',
            'email' => 'test@example.com',
            'password' => 'password',
            'type' => 'business',
        ]);

        $this->assertAuthenticated();
        $this->assertCount(1, Business::all());
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testNewCustomerUsersCanRegister()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'phone' => '0775018795',
            'email' => 'test@example.com',
            'password' => 'password',
            'type' => 'customer',
        ]);

        $this->assertAuthenticated();
        $this->assertCount(0, Business::all());
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
