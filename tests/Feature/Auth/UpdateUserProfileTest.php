<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Tests\Contracts\Postable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserProfileTest extends TestCase implements Postable
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_view_edit_profile_view()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function an_authenticated_user_can_update_their_profile_information()
    {
        $user = create(User::class, [
            'name' => 'SpongeBob Squarepants',
        ]);

        $this->withoutExceptionHandling()
            ->actingAs($user)
            ->put('/user/profile', $this->validParameters())
            ->assertStatus(302);

        $this->assertNotEquals($user, $user->fresh());
    }

    /** @test */
    public function an_authenticated_user_can_update_their_profile_information_through_json()
    {
        $user = create(User::class, [
            'name' => 'SpongeBob Squarepants',
        ]);

        $this->withoutExceptionHandling()
            ->actingAs($user)
            ->putJson('/user/profile', $this->validParameters())
            ->assertStatus(200);

        $this->assertNotEquals($user, $user->fresh());
    }

    /** @test */
    public function a_valid_name_is_required()
    {
        $user = create(User::class);

        $response = $this->actingAs($user)
            ->from('/user/profile')
            ->put('/user/profile', $this->validParameters([
                'name' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/user/profile')
            ->assertSessionHasErrorsIn('updateProfileInformation', 'name');
    }

    /** @test */
    public function a_valid_username_is_required()
    {
        $user = create(User::class);

        $response = $this->actingAs($user)
            ->from('/user/profile')
            ->put('/user/profile', $this->validParameters([
                'username' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/user/profile')
            ->assertSessionHasErrorsIn('updateProfileInformation', 'username');
    }

    /** @test */
    public function a_valid_email_is_required()
    {
        $user = create(User::class);

        $response = $this->actingAs($user)
            ->from('/user/profile')
            ->put('/user/profile', $this->validParameters([
                'email' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/user/profile')
            ->assertSessionHasErrorsIn('updateProfileInformation', 'email');
    }

    /** @test */
    public function a_valid_phone_is_required()
    {
        $user = create(User::class);

        $response = $this->actingAs($user)
            ->from('/user/profile')
            ->put('/user/profile', $this->validParameters([
                'phone' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/user/profile')
            ->assertSessionHasErrorsIn('updateProfileInformation', 'phone');
    }

    /**
     * Array of all valid parameters.
     *
     * @param array $override
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ], $overrides);
    }
}
