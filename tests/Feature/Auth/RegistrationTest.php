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
