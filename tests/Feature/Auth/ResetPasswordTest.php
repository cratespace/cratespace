<?php

namespace Tests\Feature\Auth;

use Mockery as m;
use Tests\TestCase;
use Illuminate\Support\Facades\Password;
use App\Contracts\Auth\ResetsUserPasswords;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\Authenticatable;

class ResetPasswordTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function only_authorized_users_can_view_new_password_view()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_users_password_can_be_reset()
    {
        Password::shouldReceive('broker')->andReturn($broker = m::mock(PasswordBroker::class));

        $guard = $this->mock(StatefulGuard::class);
        $user = m::mock(Authenticatable::class);

        $user->shouldReceive('setRememberToken')->once();
        $user->shouldReceive('save')->once();

        $guard->shouldReceive('login')->once();

        $updater = $this->mock(ResetsUserPasswords::class);
        $updater->shouldReceive('reset')->once()->with($user, m::type('array'));

        $broker->shouldReceive('reset')->andReturnUsing(function ($input, $callback) use ($user) {
            $callback($user, 'password');

            return Password::PASSWORD_RESET;
        });

        $response = $this->withoutExceptionHandling()->post('/reset-password', [
            'token' => 'token',
            'email' => 'johnny@doe.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/signin');
    }

    public function a_user_password_reset_request_can_fail()
    {
        Password::shouldReceive('broker')->andReturn($broker = m::mock(PasswordBroker::class));

        $guard = $this->mock(StatefulGuard::class);
        $user = m::mock(Authenticatable::class);

        $broker->shouldReceive('reset')->andReturnUsing(function ($input, $callback) {
            return Password::INVALID_TOKEN;
        });

        $response = $this->withoutExceptionHandling()->post('/reset-password', [
            'token' => 'token',
            'email' => 'johnny@doe.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function a_user_password_reset_request_can_fail_with_json()
    {
        Password::shouldReceive('broker')->andReturn($broker = m::mock(PasswordBroker::class));

        $broker->shouldReceive('reset')->andReturnUsing(function ($input, $callback) {
            return Password::INVALID_TOKEN;
        });

        $response = $this->postJson('/reset-password', [
            'token' => 'token',
            'email' => 'johnny@doe.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }
}
