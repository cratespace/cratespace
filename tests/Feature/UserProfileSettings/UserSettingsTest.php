<?php

namespace Tests\Feature\UserProfileSettings;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Ability;

class UserSettingsTest extends TestCase
{
    /** @test */
    public function a_user_is_allowed_to_view_respective_settings_page()
    {
        $customer = Role::firstOrCreate([
            'title' => 'customer',
            'label' => 'Customer',
        ]);

        $purchaseSpaces = Ability::firstOrCreate([
            'title' => 'purchase_spaces',
            'label' => 'Purchase spaces',
        ]);

        $customer->allowTo($purchaseSpaces);

        $customerUser = create(User::class);

        $customerUser->assignRole($customer);

        $this->signIn($customerUser);

        $this->get("/users/{$customerUser->username}/edit")
            ->assertStatus(403);

        $business = Role::firstOrCreate([
            'title' => 'business',
            'label' => 'Business',
        ]);

        $viewSettings = Ability::firstOrCreate([
            'title' => 'edit_user_settings',
            'label' => 'Edit user settings',
        ]);

        $business->allowTo($viewSettings);

        $businessUser = create(User::class);

        $businessUser->assignRole($business);

        $this->signIn($businessUser);

        $this->get("/users/{$businessUser->username}/edit")
            ->assertStatus(200)
            ->assertSee($businessUser->name);
    }

    /** @test */
    public function only_users_with_permission_can_edit_respective_settings()
    {
        $business = Role::firstOrCreate([
            'title' => 'business',
            'label' => 'Business',
        ]);

        $viewSettings = Ability::firstOrCreate([
            'title' => 'edit_user_settings',
            'label' => 'Edit user settings',
        ]);

        $business->allowTo($viewSettings);

        $businessUser = create(User::class);

        $businessUser->assignRole($business);

        $this->signIn($businessUser);

        $this->assertEquals(auth()->user()->name, $businessUser->name);

        $response = $this->put("/users/{$businessUser->username}", [
            'name' => 'John Doe',
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertEquals(auth()->user()->refresh()->name, $businessUser->refresh()->name);
    }
}
