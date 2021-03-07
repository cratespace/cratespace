<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TwoFactorAuthenticationSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function testTwoFactorAuthenticationCanBeEnabled()
    {
        $this->signIn($user = create(User::class));

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $response = $this->post('/user/two-factor-authentication');

        $this->assertNotNull($user->fresh()->two_factor_secret);
        $this->assertCount(8, $user->fresh()->recoveryCodes());
    }

    public function testRecoveryCodesCanBeRegenerated()
    {
        $this->signIn($user = create(User::class));

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->post('/user/two-factor-authentication');
        $this->post('/user/two-factor-recovery-codes');

        $user = $user->fresh();

        $this->post('/user/two-factor-recovery-codes');

        $this->assertCount(8, $user->recoveryCodes());
        $this->assertCount(8, array_diff($user->recoveryCodes(), $user->fresh()->recoveryCodes()));
    }

    public function testTwoFactorAuthenticationCanBeDisabled()
    {
        $this->signIn($user = create(User::class));

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->post('/user/two-factor-authentication');

        $this->assertNotNull($user->fresh()->two_factor_secret);

        $this->delete('/user/two-factor-authentication');

        $this->assertNull($user->fresh()->two_factor_secret);
    }
}
