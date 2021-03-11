<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Business;
use App\Billing\Clients\Stripe;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'Customer', 'slug' => 'customer']);
        Role::create(['name' => 'Business', 'slug' => 'business']);
    }

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

        $user = User::whereName('Test User')->first();
        $customer = app(Stripe::class)->getCustomer($user->customer->stripe_id);

        $this->assertNotNull($customer);
        $this->assertEquals('test@example.com', $customer->email);
        $this->assertEquals('Test User', $customer->name);
        $this->assertEquals('0775018795', $customer->phone);
    }
}
