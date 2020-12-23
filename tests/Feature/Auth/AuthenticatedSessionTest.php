<?php

namespace Tests\Feature\Auth;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use Tests\Contracts\Postable;
use App\Guards\LoginRateLimiter;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticatedSessionTest extends TestCase implements Postable
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_authenticate()
    {
        $user = create(User::class, [
            'email' => 'james@silverman.com',
            'password' => bcrypt('monster'),
        ]);

        $response = $this->post('/signin', $this->validParameters());

        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertTrue(auth()->user()->is($user));
    }

    /** @test */
    public function a_user_with_locked_account_cannot_authenticate()
    {
        $user = create(User::class, [
            'email' => 'james@silverman.com',
            'password' => bcrypt('monster'),
            'locked' => true,
        ]);

        $response = $this->post('/signin', $this->validParameters());

        $response->status(401);
        $this->assertFalse(auth()->check());
    }

    /** @test */
    public function a_validation_exception_is_returned_on_failure()
    {
        create(User::class, [
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
    public function a_valid_email_is_required()
    {
        $response = $this->from('/signin')
            ->post('/signin', $this->validParameters([
                'email' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/signin')
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_valid_password_is_required()
    {
        $response = $this->from('/signin')
            ->post('/signin', $this->validParameters([
                'password' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/signin')
            ->assertSessionHasErrors('password');
    }

    /** @test */
    public function login_attempts_are_throttled()
    {
        create(User::class, [
            'email' => 'james@silverman.com',
            'password' => bcrypt('monster'),
        ]);

        $this->mock(LoginRateLimiter::class, function ($mock) {
            $mock->shouldReceive('tooManyAttempts')->andReturn(true);
            $mock->shouldReceive('availableIn')->andReturn(10);
        });

        $response = $this->postJson('/signin', $this->validParameters());

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

    /** @test */
    public function a_user_is_redirected_to_challenge_when_using_two_factor_authentication()
    {
        create(User::class, [
            'email' => 'james@silverman.com',
            'password' => bcrypt('monster'),
            'two_factor_enabled' => true,
        ]);

        $response = $this->withoutExceptionHandling()->post('/signin', $this->validParameters());

        $response->assertRedirect('/tfa-challenge');
    }

    /** @test */
    public function a_user_can_authenticate_when_two_factor_challenge_is_disabled()
    {
        create(User::class, [
            'email' => 'james@silverman.com',
            'password' => bcrypt('monster'),
            'two_factor_enabled' => false,
        ]);

        $response = $this->withoutExceptionHandling()->post('/signin', $this->validParameters());

        $response->assertRedirect('/home');
    }

    /** @test */
    public function two_factor_challenge_can_be_passed_via_code()
    {
        $tfaEngine = app(Google2FA::class);
        $userSecret = $tfaEngine->generateSecretKey();
        $validOtp = $tfaEngine->getCurrentOtp($userSecret);

        $user = create(User::class, [
            'email' => 'james@silverman.com',
            'password' => bcrypt('monster'),
            'two_factor_secret' => encrypt($userSecret),
        ]);

        $response = $this->withSession([
            'signin.id' => $user->id,
            'signin.remember' => false,
        ])->withoutExceptionHandling()->post('/tfa-challenge', [
            'code' => $validOtp,
        ]);

        $response->assertRedirect('/home');
    }

    /** @test */
    public function two_factor_challenge_can_be_passed_via_recovery_code()
    {
        $user = create(User::class, [
            'email' => 'james@silverman.com',
            'password' => bcrypt('monster'),
            'two_factor_recovery_codes' => encrypt(json_encode(['invalid-code', 'valid-code'])),
        ]);

        $response = $this->withSession([
            'signin.id' => $user->id,
            'signin.remember' => false,
        ])->withoutExceptionHandling()->post('/tfa-challenge', [
            'recovery_code' => 'valid-code',
        ]);

        $response->assertRedirect('/home');
        $this->assertNotNull(Auth::getUser());
        $this->assertNotContains('valid-code', json_decode(decrypt($user->fresh()->two_factor_recovery_codes), true));
    }

    /** @test */
    public function two_factor_challenge_can_fail_via_recovery_code()
    {
        $user = create(User::class, [
            'email' => 'james@silverman.com',
            'password' => bcrypt('monster'),
            'two_factor_recovery_codes' => encrypt(json_encode(['invalid-code', 'valid-code'])),
        ]);

        $response = $this->withSession([
            'login.id' => $user->id,
            'login.remember' => false,
        ])->withoutExceptionHandling()->post('/tfa-challenge', [
            'recovery_code' => 'missing-code',
        ]);

        $response->assertRedirect('/signin');
        $this->assertNull(Auth::getUser());
    }

    /**
     * Array of all valid parameters.
     *
     * @param array $override
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'email' => 'james@silverman.com',
            'password' => 'monster',
        ], $overrides);
    }
}
