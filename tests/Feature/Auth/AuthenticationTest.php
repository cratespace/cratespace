<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class AuthenticationTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testLoginScreenCanBeRendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testUserCanAuthenticateThroughJson()
    {
        $user = create(User::class);

        $response = $this->postJson('/login', $this->validParameters([
            'email' => $user->email,
            'password' => 'password',
        ]));

        $response->assertStatus(200);
        $this->assertAuthenticated();
    }

    public function testBusinessUsersCanAuthenticateUsingTheLoginScreen()
    {
        $user = User::factory()->asBusiness()->create();

        $response = $this->post('/login', $this->validParameters([
            'email' => $user->email,
            'password' => 'password',
        ]));

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testCustomerUsersCanAuthenticateUsingTheLoginScreen()
    {
        $user = User::factory()->asCustomer()->create();

        $response = $this->post('/login', $this->validParameters([
            'email' => $user->email,
            'password' => 'password',
        ]));

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testUsersCanNotAuthenticateWithInvalidEmail()
    {
        $user = create(User::class);

        $response = $this->post('/login', $this->validParameters([
            'email' => '',
            'password' => $user->password,
        ]));

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function testUsersCanNotAuthenticateWithInvalidPassword()
    {
        $user = create(User::class);

        $this->post('/login', $this->validParameters([
            'email' => $user->email,
            'password' => 'wrong-password',
        ]));

        $this->assertGuest();
    }

    public function testCustomersCannotAccessBusinessArea()
    {
        $user = User::factory()->asCustomer()->create();

        $this->signIn($user);

        $response = $this->get('/home');

        $response->assertRedirect('/');
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
            'email' => null,
            'password' => null,
        ], $overrides);
    }
}
