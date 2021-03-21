<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
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

    public function testNewBusinessUserCanRegister()
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

    public function testNewCustomerCanRegister()
    {
        $this->withoutExceptionHandling();

        $this->createDefaults();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'TestUser',
            'email' => 'test@example.com',
            'password' => 'password',
            'type' => 'customer',
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'postcode' => $this->faker->postcode,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertNotNull(Auth::user()->profile->stripe_id);
    }
}
