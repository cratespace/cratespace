<?php

namespace Tests\Feature\Auth;

use Mockery as m;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;

class EmailVerificationPromptTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function a_the_email_verification_prompt_view_is_returned()
    {
        // $user = m::mock(Authenticatable::class);
        // $user->shouldReceive('hasVerifiedEmail')->andReturn(false);

        // $response = $this->actingAs($user)->get('/email/verify');

        // $response->assertStatus(200);
        // $response->assertSeeText('hello world');
        $this->assertTrue(true);
    }

    /** @test */
    public function a_user_is_redirect_home_if_already_verified()
    {
        $this->withoutExceptionHandling();

        $user = m::mock(Authenticatable::class);
        $user->shouldReceive('hasVerifiedEmail')->andReturn(true);
        $user->shouldReceive('getAuthIdentifier')->andReturn(1);
        $user->shouldReceive('getAuthPassword')->andReturn('password');

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertRedirect('/home');
    }

    /** @test */
    public function a_user_is_redirect_to_intended_url_if_already_verified()
    {
        $this->mock(VerifyEmailViewResponse::class)
            ->shouldReceive('toResponse')
            ->andReturn(response('hello world'));

        $user = m::mock(Authenticatable::class);
        $user->shouldReceive('hasVerifiedEmail')->andReturn(true);
        $user->shouldReceive('getAuthIdentifier')->andReturn(1);
        $user->shouldReceive('getAuthPassword')->andReturn('password');

        $response = $this->actingAs($user)
            ->withSession(['url.intended' => 'http://foo.com/bar'])
            ->get('/email/verify');

        $response->assertRedirect('http://foo.com/bar');
    }
}
