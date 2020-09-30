<?php

namespace Tests\Feature\UserProfileSettings;

use Tests\TestCase;
use App\Models\User;

class UpdateUserPasswordTest extends TestCase
{
    /** @test */
    public function user_can_update_password()
    {
        $response = $this->put('/users/james/update/password', [
            'current_password' => 'oldPassword',
            'password' => 'newPassword',
            'password_confirmation' => 'newPassword',
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/login');

        $user = $this->signIn(create(User::class, ['password' => 'oldPassword']));

        $response = $this->putJson("/users/{$user->username}/update/password", [
            'current_password' => 'oldPassword',
            'password' => 'newPassword',
            'password_confirmation' => 'newPassword',
        ]);

        $response->assertSessionHasNoErrors()->assertStatus(204);
    }

    /** @test */
    public function it_redirects_back_if_current_password_is_not_provided()
    {
        $user = $this->signIn(create(User::class, ['password' => 'oldPassword']));

        $response = $this->put("/users/{$user->username}/update/password", [
            'password' => 'newPassword',
            'password_confirmation' => 'newPassword',
        ]);

        $response->assertSessionMissing('password')->assertStatus(302);

        $response = $this->putJson("/users/{$user->username}/update/password", [
            'password' => 'newPassword',
            'password_confirmation' => 'newPassword',
        ]);

        $response->assertSessionMissing('password')->assertStatus(422);
    }
}
