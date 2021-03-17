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

    /**
     * Fake user istance.
     *
     * @var \App\Models\User
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = create(User::class);
    }

    public function testLoginScreenCanBeRendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testUsersCanAuthenticateUsingTheLoginScreen()
    {
        $response = $this->from('/login')->post('/login', $this->validParameters());

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testCanAuthenticateThroughJson()
    {
        $response = $this->postJson('/login', $this->validParameters());

        $this->assertAuthenticated();
        $response->assertStatus(200);
    }

    public function testValidEmailIsRequired()
    {
        $this->postJson('/login', $this->validParameters([
            'email' => '',
        ]));

        $this->assertGuest();
    }

    public function testUsersCanNotAuthenticateWithInvalidPassword()
    {
        $response = $this->post('/login', $this->validParameters([
            'password' => 'invalid-password',
        ]));

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
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
            'email' => $this->user->email,
            'password' => 'password',
        ], $overrides);
    }
}
