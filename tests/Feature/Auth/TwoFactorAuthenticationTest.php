<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use App\Events\TwoFactorAuthenticationEnabled;
use App\Events\TwoFactorAuthenticationDisabled;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testTwoFactorAuthenticationCanBeEnabled()
    {
        Event::fake();

        $user = create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
        ]));

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson('/user/two-factor-authentication');

        $response->assertStatus(204);

        Event::assertDispatched(TwoFactorAuthenticationEnabled::class);

        $user->fresh();

        $this->assertNotNull($user->two_factor_secret);
        $this->assertNotNull($user->two_factor_recovery_codes);
        $this->assertIsArray(json_decode(decrypt($user->two_factor_recovery_codes), true));
        $this->assertNotNull($user->twoFactorQrCodeSvg());
    }

    public function testTwoFactorAuthenticationCanBeDisabled()
    {
        Event::fake();

        $user = create(User::class, $this->validParameters([
            'password' => Hash::make('cthuluEmployee'),
            'two_factor_secret' => encrypt('foo'),
            'two_factor_recovery_codes' => encrypt(json_encode([])),
        ]));

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->deleteJson('/user/two-factor-authentication');

        $response->assertStatus(204);

        Event::assertDispatched(TwoFactorAuthenticationDisabled::class);

        $user->fresh();

        $this->assertNull($user->two_factor_secret);
        $this->assertNull($user->two_factor_recovery_codes);
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
