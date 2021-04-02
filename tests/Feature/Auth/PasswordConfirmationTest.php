<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class PasswordConfirmationTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testConfirmPasswordScreenCanBeRendered()
    {
        $user = User::factory()->asBusiness()->create();

        $response = $this->signIn($user)->get('/user/confirm-password');

        $response->assertStatus(200);
    }

    public function testPasswordCanBeConfirmed()
    {
        $user = User::factory()->asBusiness()->create();

        $response = $this->signIn($user)->post('/user/confirm-password', $this->validParameters());

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function testPasswordIsNotConfirmedWithInvalidPassword()
    {
        $user = User::factory()->asBusiness()->create();

        $response = $this->signIn($user)->post('/user/confirm-password', $this->validParameters([
            'password' => 'wrong-password',
        ]));

        $response->assertSessionHasErrors();
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
            'password' => 'password',
        ], $overrides);
    }
}
