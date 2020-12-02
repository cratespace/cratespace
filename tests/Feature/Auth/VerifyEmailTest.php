<?php

namespace Tests\Feature\Auth;

use Mockery as m;
use Tests\TestCase;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Auth\Authenticatable;

class VerifyEmailTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function an_email_can_be_verified()
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60), [
                'id' => 1,
                'hash' => sha1('jim@johnson.com'),
            ]
        );

        $user = m::mock(Authenticatable::class);
        $user->shouldReceive('getKey')->andReturn(1);
        $user->shouldReceive('getAuthIdentifier')->andReturn(1);
        $user->shouldReceive('getAuthPassword')->andReturn('password');
        $user->shouldReceive('getEmailForVerification')->andReturn('jim@johnson.com');
        $user->shouldReceive('hasVerifiedEmail')->andReturn(false);
        $user->shouldReceive('markEmailAsVerified')->once();

        $response = $this->actingAs($user)
            ->withSession(['url.intended' => 'http://foo.com/bar'])
            ->get($url);

        $response->assertRedirect('http://foo.com/bar');
    }

    /** @test */
    public function an_email_is_not_verified_if_id_does_not_match()
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => 2,
                'hash' => sha1('jim@johnson.com'),
            ]
        );

        $user = m::mock(Authenticatable::class);
        $user->shouldReceive('getKey')->andReturn(1);
        $user->shouldReceive('getAuthIdentifier')->andReturn(1);
        $user->shouldReceive('getAuthPassword')->andReturn('password');
        $user->shouldReceive('getEmailForVerification')->andReturn('jim@johnson.com');

        $response = $this->actingAs($user)->get($url);

        $response->assertStatus(403);
    }

    /** @test */
    public function an_email_is_not_verified_if_email_does_not_match()
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => 1,
                'hash' => sha1('jessica@johnson.com'),
            ]
        );

        $user = m::mock(Authenticatable::class);
        $user->shouldReceive('getKey')->andReturn(1);
        $user->shouldReceive('getAuthIdentifier')->andReturn(1);
        $user->shouldReceive('getAuthPassword')->andReturn('password');
        $user->shouldReceive('getEmailForVerification')->andReturn('jim@johnson.com');

        $response = $this->actingAs($user)->get($url);

        $response->assertStatus(403);
    }
}
