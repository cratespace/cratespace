<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tfa_requires_password_to_be_confirmed_before_enabling()
    {
        $user = create(User::class, ['password' => Hash::make('conchShell')]);

        $response = $this->actingAs($user)->postJson('/user/two-factor-authentication');

        $response->assertStatus(423);
        $this->assertEquals(
            json_decode($response->getContent(), true)['message'],
            'Password confirmation required.'
        );
    }

    /** @test */
    public function tfa_feature_can_be_enabled()
    {
        $user = create(User::class, ['password' => Hash::make('conchShell')]);

        $this->actingAs($user)
            ->postJson('/user/confirm-password', ['password' => 'conchShell'])
            ->assertStatus(201);

        $this->actingAs($user)
            ->postJson('/user/two-factor-authentication')
            ->assertSuccessful();

        $user->fresh();

        $this->assertNotNull($user->two_factor_secret);
        $this->assertNotNull($user->two_factor_recovery_codes);
        $this->assertIsArray(json_decode(decrypt($user->two_factor_recovery_codes), true));
        $this->assertNotNull($user->twoFactorQrCodeSvg());
    }

    /** @test */
    public function tfa_feature_can_be_disabled()
    {
        $user = create(User::class, ['password' => Hash::make('conchShell')]);

        $this->actingAs($user)
            ->postJson('/user/confirm-password', ['password' => 'conchShell'])
            ->assertStatus(201);

        $this->actingAs($user)
            ->deleteJson('/user/two-factor-authentication')
            ->assertSuccessful();

        $user->fresh();

        $this->assertNull($user->two_factor_secret);
        $this->assertNull($user->two_factor_recovery_codes);
    }
}
