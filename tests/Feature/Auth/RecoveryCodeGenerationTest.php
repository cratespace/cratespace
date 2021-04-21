<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use App\Events\RecoveryCodesGenerated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RecoveryCodeGenerationTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testNewRecoveryCodesCanBeGenerated()
    {
        Event::fake();

        $user = create(User::class, [
            'name' => 'James Silverman',
            'username' => 'Silver Monster',
            'email' => 'silver.james@monster.com',
            'password' => bcrypt('cthuluEmployee'),
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->postJson('/user/two-factor-recovery-codes');

        $response->assertStatus(201);

        Event::assertDispatched(RecoveryCodesGenerated::class);

        $user->fresh();

        $this->assertNotNull($user->two_factor_recovery_codes);
        $this->assertIsArray(json_decode(decrypt($user->two_factor_recovery_codes), true));
    }
}
