<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class UpdatePasswordTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testPasswordCanBeUpdated()
    {
        $this->signIn($user = create(User::class));

        $response = $this->put('/user/password', $this->validParameters());

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function testCurrentPasswordMustBeCorrect()
    {
        $this->signIn($user = create(User::class));

        $response = $this->put('/user/password', $this->validParameters([
            'current_password' => 'wrong-password',
        ]));

        $response->assertSessionHasErrorsIn('updatePassword', 'current_password');
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function testNewPasswordsMustMatch()
    {
        $this->signIn($user = create(User::class));

        $response = $this->put('/user/password', $this->validParameters([
            'password' => 'new-password',
            'password_confirmation' => 'wrong-password',
        ]));

        $response->assertSessionHasErrorsIn('updatePassword', 'password');
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
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
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ], $overrides);
    }
}
