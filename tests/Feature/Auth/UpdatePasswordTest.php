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
            ->put('/user/password', [
                'current_password' => 'ohsnapmate',
                'password' => 'kraytDragon',
                'password_confirmation' => 'kraytDragon',
            ]);

        $response->assertStatus(302)->assertSessionHasNoErrors();
    }

    /** @test */
    public function a_user_can_update_their_password_through_json()
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

    /** @test */
    public function a_password_update_request_can_fail()
    {
        $user = create(User::class, [
            'email' => 'jefferson@skulding.com',
            'password' => bcrypt('ohsnapmate'),
        ]);

        $response = $this->actingAs($user)
            ->put('/user/password', [
                'current_password' => 'SarlaccPit',
                'password' => 'kraytDragon',
                'password_confirmation' => 'kraytDragon',
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrorsIn('updatePassword', 'current_password');
    }

    /** @test */
    public function a_password_update_request_json_can_fail()
    {
        $user = create(User::class, [
            'email' => 'jefferson@skulding.com',
            'password' => bcrypt('ohsnapmate'),
        ]);

        $response = $this->actingAs($user)
            ->putJson('/user/password', [
                'current_password' => 'SarlaccPit',
                'password' => 'kraytDragon',
                'password_confirmation' => 'kraytDragon',
            ]);

        $response->assertStatus(422);
    }
}
