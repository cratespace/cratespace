<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use App\Contracts\Billing\Client;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class RegistrationTest extends TestCase implements Postable
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createRolesAndPermissions();
    }

    public function testRegistrationScreenCanBeRendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewBusinessUsersCanRegister()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/register', $this->validParameters());

        $this->assertAuthenticated();
        $this->assertCount(1, Business::all());
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testNewBusinessUsersCanRegisterThroughJsonRequest()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('/register', $this->validParameters());

        $this->assertAuthenticated();
        $this->assertCount(1, Business::all());
        $response->assertStatus(200);
    }

    public function testNewCustomerUsersCanRegister()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/register', $this->validParameters([
            'type' => 'customer',
        ]));

        $this->assertAuthenticated();
        $this->assertCount(0, Business::all());
        $response->assertRedirect(RouteServiceProvider::HOME);

        $user = User::whereName('Test User')->first();
        $customer = app(Client::class)->getCustomer($user->customer->stripe_id);

        $this->assertNotNull($customer);
        $this->assertEquals('test@example.com', $customer->email);
        $this->assertEquals('Test User', $customer->name);
        $this->assertEquals('0775018795', $customer->phone);
    }

    public function testNewCustomerUsersCanRegisterThroughJson()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('/register', $this->validParameters([
            'type' => 'customer',
        ]));

        $this->assertAuthenticated();
        $this->assertCount(0, Business::all());
        $response->assertStatus(200);

        $user = User::whereName('Test User')->first();
        $customer = app(Client::class)->getCustomer($user->customer->stripe_id);

        $this->assertNotNull($customer);
        $this->assertEquals('test@example.com', $customer->email);
        $this->assertEquals('Test User', $customer->name);
        $this->assertEquals('0775018795', $customer->phone);
    }

    public function testValidNameIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'name' => '',
        ]));

        $this->assertGuest();
        $response->assertSessionHasErrors('name');
    }

    public function testValidEmailIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'email' => '',
        ]));

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function testValidPasswordIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'password' => '',
        ]));

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    public function testBusinessIsOptionalIfRegisteringAsCustomer()
    {
        $response = $this->post('/register', $this->validParameters([
            'business' => '',
            'type' => 'customer',
        ]));

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testValidTypeIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'type' => 'editor',
        ]));

        $this->assertGuest();
        $response->assertSessionHasErrors('type');
    }

    public function testBusinessIsRequiredIfRegisteringAsBusiness()
    {
        $response = $this->post('/register', $this->validParameters([
            'business' => '',
            'type' => 'business',
        ]));

        $this->assertGuest();
        $response->assertSessionHasErrors('business');
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
            'name' => 'Test User',
            'business' => 'Example, Inc.',
            'phone' => '0775018795',
            'email' => 'test@example.com',
            'password' => 'password',
            'type' => 'business',
        ], $overrides);
    }
}
