<?php

namespace Tests\Feature\Auth;

use Mockery as m;
use Tests\TestCase;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;

class ResetPasswordRequestLinkTest extends TestCase
{
    /** @test */
    public function a_user_can_see_reset_link_request_view()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function reset_link_can_be_successfully_requested()
    {
        Password::shouldReceive('broker')->andReturn($broker = m::mock(PasswordBroker::class));

        $broker->shouldReceive('sendResetLink')->andReturn(Password::RESET_LINK_SENT);

        $response = $this->from(url('/forgot-password'))
            ->post('/forgot-password', [
                'email' => 'mando@lorian.com',
            ]);

        $response->assertStatus(302);
        $response->assertRedirect('/forgot-password');
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('status', trans(Password::RESET_LINK_SENT));
    }

    /** @test */
    public function reset_link_request_can_fail()
    {
        Password::shouldReceive('broker')->andReturn($broker = m::mock(PasswordBroker::class));

        $broker->shouldReceive('sendResetLink')->andReturn(Password::INVALID_USER);

        $response = $this->from(url('/forgot-password'))
            ->post('/forgot-password', ['email' => 'mando@lorian.com']);

        $response->assertStatus(302);
        $response->assertRedirect('/forgot-password');
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function reset_link_request_can_fail_with_json()
    {
        Password::shouldReceive('broker')->andReturn($broker = m::mock(PasswordBroker::class));

        $broker->shouldReceive('sendResetLink')->andReturn(Password::INVALID_USER);

        $response = $this->from(url('/forgot-password'))
            ->postJson('/forgot-password', ['email' => 'mando@lorian.com']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }
}
