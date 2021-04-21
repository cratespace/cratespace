<?php

namespace Tests\Feature\Auth;

use Throwable;
use Tests\TestCase;
use App\Models\User;
use Tests\Contracts\Postable;
use PragmaRX\Google2FA\Google2FA;
use App\Limiters\LoginRateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use App\Events\TwoFactorAuthenticationChallenged;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testLoginViewResponseIsReturned()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testUserCanAuthenticate()
    {
        $user = create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
        ]));

        $response = $this->post('/login', $this->validParameters());

        $response->assertRedirect('/home');

        $this->assertAuthenticatedAs($user);
    }

    public function testUserCanAuthenticateThroughJsonRequest()
    {
        $user = create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
        ]));

        $response = $this->postJson('/login', $this->validParameters());

        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);
    }

    public function testValidEmailIsRequired()
    {
        create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
        ]));

        $response = $this->from('/login')->post('/login', $this->validParameters([
            'email' => '',
        ]));

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function testValidPasswordIsRequired()
    {
        create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
        ]));

        $response = $this->from('/login')
            ->post('/login', $this->validParameters([
                'password' => '',
            ]));

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function testValidationExceptionReturnedOnFailure()
    {
        $this->withoutExceptionHandling();

        create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
        ]));

        try {
            $this->post('/login', [
                'email' => 'james.silverman@monster.com',
                'password' => 'cthuluHimself',
            ]);
        } catch (Throwable $e) {
            $this->assertInstanceOf(ValidationException::class, $e);
            $this->assertEquals('The given data was invalid.', $e->getMessage());

            return;
        }

        $this->fail('Validation exception was not thrown');
    }

    public function testLoginAttemptsAreThrottled()
    {
        $this->mock(LoginRateLimiter::class, function ($mock) {
            $mock->shouldReceive('tooManyAttempts')->andReturn(true);
            $mock->shouldReceive('availableIn')->andReturn(10);
        });

        $response = $this->postJson('/login', [
            'email' => 'james.silverman@monster.com',
            'password' => 'cthuluEmployee',
        ]);

        $response->assertStatus(429);
        $response->assertJsonValidationErrors(['email']);
    }

    public function testLockedUserAccountsAreDenied()
    {
        create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
            'locked' => true,
        ]));

        $response = $this->post('/login', [
            'email' => 'james.silverman@monster.com',
            'password' => 'cthuluEmployee',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testTheUserCanLogoutOfTheApplication()
    {
        $this->withoutExceptionHandling();

        Auth::guard()->setUser(
            $user = create(User::class, $this->validParameters([
                'password' => Hash::make('cthuluEmployee'),
            ]))
        );

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertNull(Auth::guard()->getUser());
    }

    public function testTheUserCanLogoutOfTheApplicationUsingJsonRequest()
    {
        Auth::guard()->setUser(
            $user = create(User::class, $this->validParameters([
                'password' => Hash::make('cthuluEmployee'),
            ]))
        );

        $response = $this->actingAs($user)->postJson('/logout');

        $response->assertStatus(204);
        $this->assertNull(Auth::guard()->getUser());
    }

    public function testUserIsRedirectedToChallengeWhenUsingTwoFactorAuthentication()
    {
        Event::fake();

        $user = create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
            'two_factor_secret' => 'test-secret',
        ]));

        $response = $this->withoutExceptionHandling()->post('/login', [
            'email' => 'james.silverman@monster.com',
            'password' => 'cthuluEmployee',
        ]);

        $response->assertRedirect('/two-factor-challenge');

        Event::assertDispatched(TwoFactorAuthenticationChallenged::class);
    }

    public function testTwoFactorChallengeCanBePassedViaCode()
    {
        $tfaEngine = app(Google2FA::class);
        $userSecret = $tfaEngine->generateSecretKey();
        $validOtp = $tfaEngine->getCurrentOtp($userSecret);

        $user = create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
            'two_factor_secret' => encrypt($userSecret),
        ]));

        $response = $this->withSession([
            'login.id' => $user->id,
            'login.remember' => false,
        ])->withoutExceptionHandling()->post('/two-factor-challenge', [
            'code' => $validOtp,
        ]);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testTwoFactorChallengeCanBePassedViaRecoveryCode()
    {
        $user = create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
            'two_factor_recovery_codes' => encrypt(json_encode([
                'invalid-code', 'valid-code',
            ])),
        ]));

        $response = $this->withSession([
            'login.id' => $user->id,
            'login.remember' => false,
        ])->withoutExceptionHandling()->post('/two-factor-challenge', [
            'recovery_code' => 'valid-code',
        ]);

        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertNotNull(Auth::getUser());
        $this->assertNotContains('valid-code', json_decode(decrypt($user->fresh()->two_factor_recovery_codes), true));
    }

    public function testTwoFactorChallengeCanFailViaRecoveryCode()
    {
        $user = create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
            'two_factor_recovery_codes' => encrypt(json_encode([
                'invalid-code', 'valid-code',
            ])),
        ]));

        $response = $this->withSession([
            'login.id' => $user->id,
            'login.remember' => false,
        ])->withoutExceptionHandling()->post('/two-factor-challenge', [
            'recovery_code' => 'missing-code',
        ]);

        $response->assertRedirect('/login');
        $this->assertNull(Auth::getUser());
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
            'email' => 'james.silverman@monster.com',
            'password' => 'cthuluEmployee',
        ], $overrides);
    }
}
