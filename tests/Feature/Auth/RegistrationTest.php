<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\Customer;
use Tests\Concerns\CreatesRoles;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class RegistrationTest extends TestCase implements Postable
{
    use CreatesRoles;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createDefaultRoles();
    }

    public function testRegistrationScreenCanBeRendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewUsersCanRegister()
    {
        $response = $this->post('/register', $this->validParameters());

        $this->assertAuthenticated();
        $this->assertCount(1, Customer::all());
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testNewUsersCanRegisterThrougJsonRequest()
    {
        $response = $this->postJson('/register', $this->validParameters());

        $this->assertAuthenticated();
        $response->assertStatus(201);
    }

    public function testValidNameIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'name' => '',
        ]));

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }

    public function testValidEmailIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'email' => '',
        ]));

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function testValidPhoneIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'phone' => '',
        ]));

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertSessionHasErrors('phone');
    }

    public function testValidPasswordIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'password' => '',
        ]));

        $this->assertGuest();
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
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0712345678',
            'password' => 'password',
            'password_confirmation' => 'password',
            'type' => 'customer',
        ], $overrides);
    }
}
