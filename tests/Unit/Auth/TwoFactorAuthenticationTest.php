<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Traits\TwoFactorAuthenticatable;

class TwoFactorAuthenticationTest extends TestCase
{
    /** @test */
    public function two_factor_authentication_can_be_enabled()
    {
        $user = TestTwoFactorAuthenticationUser::forceCreate([
            'name' => 'Thavarshan',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        $response = $this->withoutExceptionHandling()->actingAs($user)->postJson(
            '/user/two-factor-authentication'
        );

        $response->assertStatus(200);

        $user->fresh();

        $this->assertNotNull($user->two_factor_secret);
        $this->assertNotNull($user->two_factor_recovery_codes);
        $this->assertIsArray(json_decode(decrypt($user->two_factor_recovery_codes), true));
        $this->assertNotNull($user->twoFactorQrCodeSvg());
    }

    /** @test */
    public function two_factor_authentication_can_be_disabled()
    {
        $user = TestTwoFactorAuthenticationUser::forceCreate([
            'name' => 'Thavarshan',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'password' => bcrypt('secret'),
            'two_factor_secret' => encrypt('foo'),
            'two_factor_recovery_codes' => encrypt(json_encode([])),
        ]);

        $response = $this->withoutExceptionHandling()->actingAs($user)->deleteJson(
            '/user/two-factor-authentication'
        );

        $response->assertStatus(200);

        $user->fresh();

        $this->assertNull($user->two_factor_secret);
        $this->assertNull($user->two_factor_recovery_codes);
    }
}

class TestTwoFactorAuthenticationUser extends User
{
    use TwoFactorAuthenticatable;

    protected $table = 'users';
}
