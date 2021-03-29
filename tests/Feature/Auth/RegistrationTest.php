<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Services\Stripe\Customer;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Auth\Concerns\CreateDefaultUser;
use Cratespace\Preflight\Testing\Contracts\Postable;

class RegistrationTest extends TestCase implements Postable
{
    use RefreshDatabase;
    use CreateDefaultUser;

    public function testRegistrationScreenCanBeRendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewCustomerCanRegister()
    {
        $this->withoutExceptionHandling();

        $this->createDefaults();

        $response = $this->post('/register', $this->validParameters());

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertNotNull($id = Auth::user()->profile->stripe_id);

        $customer = new Customer($id);
        $customer->delete();
    }

    public function testNewCustomerCanRegisterThroughJson()
    {
        $this->withoutExceptionHandling();

        $this->createDefaults();

        $response = $this->postJson('/register', $this->validParameters());

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $this->assertNotNull($id = Auth::user()->profile->stripe_id);

        $customer = new Customer($id);
        $customer->delete();
    }

    public function testValidNameIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'name' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }

    public function testValidEmailIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'email' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function testValidPhoneIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'phone' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('phone');
    }

    public function testValidPasswordIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'password' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
    }

    /**
     * Provide only the necessary paramertes for a POST-able type request.
     *
     * @param array $overrides
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Father Jack Hackett',
            'email' => 'fr.j.hackett@craggyisle.com',
            'phone' => '0712345678',
            'password' => 'dontTellMeImStillInThatFekingIsland',
            'type' => 'customer',
        ], $overrides);
    }
}
