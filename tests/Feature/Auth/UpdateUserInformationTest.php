<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Tests\Contracts\Postable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserInformationTest extends TestCase implements Postable
{
    use RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_update_profile_information()
    {
        $user = create(User::class);
        $name = $user->name;

        $this->actingAs($user)
            ->putJson('/user/profile-information', $this->validParameters())
            ->assertStatus(200);

        $this->assertNotEquals($name, auth()->user()->name);
    }

    /** @test */
    public function a_valid_name_is_required()
    {
        $user = create(User::class);

        $this->actingAs($user)
            ->put('/user/profile-information', $this->validParameters([
                'name' => '',
            ]))
            ->assertStatus(302)
            ->assertSessionHasErrorsIn('updateProfileInformation', 'name');
    }

    /** @test */
    public function a_valid_email_is_required()
    {
        $user = create(User::class);

        $this->actingAs($user)
            ->put('/user/profile-information', $this->validParameters([
                'email' => '',
            ]))
            ->assertStatus(302)
            ->assertSessionHasErrorsIn('updateProfileInformation', 'email');
    }

    /** @test */
    public function a_valid_username_is_required()
    {
        $user = create(User::class);

        $this->actingAs($user)
            ->put('/user/profile-information', $this->validParameters([
                'username' => '',
            ]))
            ->assertStatus(302)
            ->assertSessionHasErrorsIn('updateProfileInformation', 'username');
    }

    /** @test */
    public function a_valid_phone_number_is_required()
    {
        $user = create(User::class);

        $this->actingAs($user)
            ->put('/user/profile-information', $this->validParameters([
                'phone' => '',
            ]))
            ->assertStatus(302)
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
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ], $overrides);
    }
}
