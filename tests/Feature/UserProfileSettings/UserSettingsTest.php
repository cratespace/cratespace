<?php

namespace Tests\Feature\UserProfileSettings;

use Tests\TestCase;
use App\Models\User;

class UserSettingsTest extends TestCase
{
    /** @test */
    public function a_user_is_allowed_to_view_respective_settings_page()
    {
        $user = $this->signIn();

        auth()->logout();

        $this->get("/users/{$user->username}/edit")->assertStatus(302);

        $this->signIn($user);

        $this->get("/users/{$user->username}/edit")
            ->assertStatus(200)
            ->assertSee($user->name);
    }

    /** @test */
    public function only_users_with_permission_can_edit_respective_settings()
    {
        $randomUser = create(User::class);
        $user = $this->signIn();

        $this->assertNotEquals(auth()->user()->name, $randomUser->name);
        $this->assertEquals(auth()->user()->name, $user->name);

        $this->actingAs($user)->put("/users/{$randomUser->username}", [
            'name' => 'John Doe',
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ])->assertStatus(403);

        $this->actingAs($user)->put("/users/{$user->username}", [
            'name' => 'John Doe',
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ])->assertSessionHasNoErrors();

        $this->assertEquals(auth()->user()->refresh()->name, $user->refresh()->name);
    }
}
