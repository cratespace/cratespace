<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_update_their_password()
    {
        $user = create(User::class, [
            'email' => 'jefferson@skulding.com',
            'password' => bcrypt('ohsnapmate'),
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->putJson('/user/password', [
                'current_password' => 'ohsnapmate',
                'password' => 'kraytDragon',
                'password_confirmation' => 'kraytDragon',
            ]);

        $response->assertStatus(200);
    }
}
