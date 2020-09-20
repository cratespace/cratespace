<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\User;

class TwoFactorAuthenticationRecoveryCodeTest extends TestCase
{
    /** @test */
    public function new_recovery_codes_can_be_generated()
    {
        $user = TestTwoFactorRecoveryCodeUser::forceCreate([
            'name' => 'Thavarshan',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        $response = $this->withoutExceptionHandling()->actingAs($user)->postJson(
            '/user/two-factor-recovery-codes'
        );

        $response->assertStatus(200);

        $user->fresh();

        $this->assertNotNull($user->two_factor_recovery_codes);
        $this->assertIsArray(json_decode(decrypt($user->two_factor_recovery_codes), true));
    }
}

class TestTwoFactorRecoveryCodeUser extends User
{
    protected $table = 'users';
}
