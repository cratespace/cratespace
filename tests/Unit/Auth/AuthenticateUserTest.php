<?php

namespace Tests\Unit\Auth;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use App\Auth\Guards\LoginRateLimiter;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Traits\TwoFactorAuthenticatable;

class AuthenticateUserTest extends TestCase
{
    /** @test */
    public function user_can_authenticate()
    {
        TestAuthenticationSessionUser::forceCreate([
            'name' => 'Thavarshan',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        $response = $this->withoutExceptionHandling()
            ->post('/login', [
                'email' => 'tjthavarshan@gmail.com',
                'password' => 'secret',
            ]);

        $response->assertRedirect('/home');
    }

    public function test_user_is_redirected_to_challenge_when_using_two_factor_authentication()
    {
        app('config')->set('auth.providers.users.model', TestTwoFactorAuthenticationSessionUser::class);

        TestTwoFactorAuthenticationSessionUser::forceCreate([
            'name' => 'Thavarshan',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'password' => bcrypt('secret'),
            'two_factor_secret' => 'test-secret',
        ]);

        $response = $this->withoutExceptionHandling()->post('/login', [
            'email' => 'tjthavarshan@gmail.com',
            'password' => 'secret',
        ]);

        $response->assertRedirect('/two-factor-challenge');
    }

    /** @test */
    public function validation_exception_returned_on_failure()
    {
        TestAuthenticationSessionUser::forceCreate([
            'name' => 'Thavarshan',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        $response = $this->post('/login', [
            'email' => 'tjthavarshan@gmail.com',
            'password' => 'password',
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

        $response = $this->postJson('/login', [
            'email' => 'tjthavarshan@gmail.com',
            'password' => 'secret',
        ]);

        $response->assertStatus(429);
        $response->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function the_user_can_logout_of_the_application()
    {
        Auth::guard()->setUser(
            Mockery::mock(Authenticatable::class)->shouldIgnoreMissing()
        );

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertNull(Auth::guard()->getUser());
    }

    /** @test */
    public function the_user_can_logout_of_the_application_using_json_request()
    {
        Auth::guard()->setUser(
            Mockery::mock(Authenticatable::class)->shouldIgnoreMissing()
        );

        $response = $this->postJson('/logout');

        $response->assertStatus(204);
        $this->assertNull(Auth::guard()->getUser());
    }

    public function test_two_factor_challenge_can_be_passed_via_code()
    {
        app('config')->set('auth.providers.users.model', TestTwoFactorAuthenticationSessionUser::class);

        $tfaEngine = app(Google2FA::class);
        $userSecret = $tfaEngine->generateSecretKey();
        $validOtp = $tfaEngine->getCurrentOtp($userSecret);

        $user = TestTwoFactorAuthenticationSessionUser::forceCreate([
            'name' => 'Thavarshan',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'password' => bcrypt('secret'),
            'two_factor_secret' => encrypt($userSecret),
        ]);

        $response = $this->withSession([
            'login.id' => $user->id,
            'login.remember' => false,
        ])
        ->withoutExceptionHandling()
        ->post('/two-factor-challenge', [
            'code' => $validOtp,
        ]);

        $response->assertRedirect('/home');
    }

    /** @test */
    public function two_factor_challenge_can_be_passed_via_recovery_code()
    {
        app('config')->set('auth.providers.users.model', TestTwoFactorAuthenticationSessionUser::class);

        $user = TestTwoFactorAuthenticationSessionUser::forceCreate([
            'name' => 'Thavarshan',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'password' => bcrypt('secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['invalid-code', 'valid-code'])),
        ]);

        $response = $this->withSession([
            'login.id' => $user->id,
            'login.remember' => false,
        ])->withoutExceptionHandling()->post('/two-factor-challenge', [
            'recovery_code' => 'valid-code',
        ]);

        $response->assertRedirect('/home');
        $this->assertNotNull(Auth::getUser());
        $this->assertNotContains('valid-code', json_decode(decrypt($user->fresh()->two_factor_recovery_codes), true));
    }

    /** @test */
    public function two_factor_challenge_can_fail_via_recovery_code()
    {
        app('config')->set('auth.providers.users.model', TestTwoFactorAuthenticationSessionUser::class);

        $user = TestTwoFactorAuthenticationSessionUser::forceCreate([
            'name' => 'Thavarshan',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'password' => bcrypt('secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['invalid-code', 'valid-code'])),
        ]);

        $response = $this->withSession([
            'login.id' => $user->id,
            'login.remember' => false,
        ])->withoutExceptionHandling()->post('/two-factor-challenge', [
            'recovery_code' => 'missing-code',
        ]);

        $response->assertRedirect('/login');
        $this->assertNull(Auth::getUser());
    }
}

class TestAuthenticationSessionUser extends User
{
    protected $table = 'users';
}

class TestTwoFactorAuthenticationSessionUser extends User
{
    use TwoFactorAuthenticatable;

    protected $table = 'users';
}
