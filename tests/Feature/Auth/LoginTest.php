<?php

namespace Tests\Feature\Auth;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use App\Guards\LoginRateLimiter;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_the_login_view()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_authenticate()
    {
        $user = create(User::class, [
            'email' => 'james@silverman.com',
            'password' => bcrypt('monster'),
        ]);

        $response = $this->withoutExceptionHandling()->post('/signin', [
            'email' => 'james@silverman.com',
            'password' => 'monster',
        ]);

        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertTrue(auth()->user()->is($user));
    }

    /** @test */
    public function a_validation_exception_is_returned_on_failure()
    {
        $user = create(User::class, [
            'email' => 'james@silverman.com',
            'password' => bcrypt('monster'),
        ]);

        $response = $this->post('/signin', [
            'email' => 'james@silverman.com',
            'password' => 'regularJoe',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function login_attempts_are_throttled()
    {
        $this->mock(LoginRateLimiter::class, function ($mock) {
            $mock->shouldReceive('tooManyAttempts')->andReturn(true);
            $mock->shouldReceive('availableIn')->andReturn(10);
        });

        $response = $this->postJson('/signin', [
            'email' => 'james@silverman.com',
            'password' => 'monster',
        ]);

        $response->assertStatus(429);
        $response->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function a_user_can_logout_of_the_application()
    {
        Auth::guard()->setUser(
            m::mock(Authenticatable::class)->shouldIgnoreMissing()
        );

        $response = $this->post('/signout');

        $response->assertRedirect('/');
        $this->assertNull(Auth::guard()->getUser());
    }

    /** @test */
    public function a_user_can_logout_of_the_application_using_json_request()
    {
        Auth::guard()->setUser(
            m::mock(Authenticatable::class)->shouldIgnoreMissing()
        );

        $response = $this->postJson('/signout');

        $response->assertStatus(204);
        $this->assertNull(Auth::guard()->getUser());
    }
}
