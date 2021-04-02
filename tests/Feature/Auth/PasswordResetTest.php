<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class PasswordResetTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testResetPasswordLinkScreenCanBeRendered()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function testResetPasswordLinkCanBeRequested()
    {
        Notification::fake();

        $user = create(User::class);

        $this->post('/forgot-password', $this->validParameters(['email' => $user->email]));

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function testValidEmailRequired()
    {
        $user = create(User::class);

        $response = $this->post('/forgot-password', $this->validParameters(['email' => '']));

        $response->assertSessionHasErrors('email');
    }

    public function testResetPasswordScreenCanBeRendered()
    {
        Notification::fake();

        $user = create(User::class);

        $this->post('/forgot-password', $this->validParameters(['email' => $user->email]));

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/' . $notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function testPasswordCanBeResetWithValidToken()
    {
        Notification::fake();

        $user = create(User::class);

        $this->post('/forgot-password', $this->validParameters(['email' => $user->email]));

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
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
            'email' => '',
        ], $overrides);
    }
}
