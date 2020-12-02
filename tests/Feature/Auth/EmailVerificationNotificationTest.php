<?php

namespace Tests\Feature\Auth;

use Mockery as m;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;

class EmailVerificationNotificationTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function email_verification_notification_can_be_sent()
    {
        $this->withoutExceptionHandling();

        $user = m::mock(Authenticatable::class);

        $user->shouldReceive('hasVerifiedEmail')->andReturn(false);
        $user->shouldReceive('getAuthIdentifier')->andReturn(1);
        $user->shouldReceive('getAuthPassword')->andReturn('password');
        $user->shouldReceive('sendEmailVerificationNotification')->once();

        $response = $this->from('/email/verify')
            ->actingAs($user)
            ->post('/email/verification-notification');

        $response->assertRedirect('/email/verify');
    }

    /** @test */
    public function a_user_is_redirect_if_already_verified()
    {
        $user = m::mock(Authenticatable::class);

        $user->shouldReceive('hasVerifiedEmail')->andReturn(true);
        $user->shouldReceive('getAuthIdentifier')->andReturn(1);
        $user->shouldReceive('getAuthPassword')->andReturn('password');
        $user->shouldReceive('sendEmailVerificationNotification')->never();

        $response = $this->from('/email/verify')
            ->actingAs($user)
            ->post('/email/verification-notification');

        $response->assertRedirect('/home');
    }

    /** @test */
    public function a_user_is_redirect_to_intended_url_if_already_verified()
    {
        $user = m::mock(Authenticatable::class);

        $user->shouldReceive('hasVerifiedEmail')->andReturn(true);
        $user->shouldReceive('getAuthIdentifier')->andReturn(1);
        $user->shouldReceive('getAuthPassword')->andReturn('password');
        $user->shouldReceive('sendEmailVerificationNotification')->never();

        $response = $this->from('/email/verify')
            ->actingAs($user)
            ->withSession(['url.intended' => 'http://foo.com/bar'])
            ->post('/email/verification-notification');

        $response->assertRedirect('http://foo.com/bar');
    }
}
