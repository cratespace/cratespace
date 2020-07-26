<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Ability;
use App\Models\Account;
use App\Models\Business;
use Illuminate\Support\Collection;

class UserTest extends TestCase
{
    /** @test */
    public function a_user_can_be_assigned_a_role()
    {
        $user = create(User::class);

        $dummyRole = Role::create([
            'title' => 'dummy_role',
            'label' => 'Dummy role',
        ]);

        $user->assignRole($dummyRole);

        $this->assertTrue($user->hasRole($dummyRole->title));
    }

    /** @test */
    public function a_user_can_be_allowed_abilities()
    {
        $user = create(User::class);

        $dummyRole = Role::create([
            'title' => 'dummy_role',
            'label' => 'Dummy role',
        ]);

        $doDummyThings = Ability::create([
            'title' => 'do_dummy_things',
            'label' => 'Do dummy things',
        ]);

        $dummyRole->allowTo($doDummyThings);

        $user->assignRole($dummyRole);

        $this->assertTrue($user->hasRole($dummyRole->title));
        $this->assertTrue($user->hasAbility($doDummyThings->title));
    }

    /** @test */
    public function a_user_can_have_many_abilities()
    {
        $user = create(User::class);

        $dummyRole = Role::create([
            'title' => 'dummy_role',
            'label' => 'Dummy role',
        ]);

        $doDummyThings = Ability::create([
            'title' => 'do_dummy_things',
            'label' => 'Do dummy things',
        ]);

        $doNoneDummyThings = Ability::create([
            'title' => 'do_none_dummy_things',
            'label' => 'Do none dummy things',
        ]);

        $doSeriousThings = Ability::create([
            'title' => 'do_serious_things',
            'label' => 'Do serious things',
        ]);

        $dummyRole->allowTo($doDummyThings);
        $dummyRole->allowTo($doNoneDummyThings);
        $dummyRole->allowTo($doSeriousThings);

        $user->assignRole($dummyRole);

        $this->assertTrue($user->hasRole($dummyRole->title));
        $this->assertTrue($user->hasAbility($doDummyThings->title));
        $this->assertTrue($user->hasAbility($doNoneDummyThings->title));
        $this->assertTrue($user->hasAbility($doSeriousThings->title));
    }

    /** @test */
    public function a_user_can_get_all_associated_abilities()
    {
        $user = create(User::class);

        $dummyRole = Role::create([
            'title' => 'dummy_role',
            'label' => 'Dummy role',
        ]);

        $doDummyThings = Ability::create([
            'title' => 'do_dummy_things',
            'label' => 'Do dummy things',
        ]);

        $doNoneDummyThings = Ability::create([
            'title' => 'do_none_dummy_things',
            'label' => 'Do none dummy things',
        ]);

        $doSeriousThings = Ability::create([
            'title' => 'do_serious_things',
            'label' => 'Do serious things',
        ]);

        $dummyRole->allowTo($doDummyThings);
        $dummyRole->allowTo($doNoneDummyThings);
        $dummyRole->allowTo($doSeriousThings);

        $user->assignRole($dummyRole);

        $this->assertInstanceOf(Collection::class, $user->abilities());

        foreach ($user->abilities() as $ability) {
            $this->assertTrue($user->hasAbility($ability));
        }
    }

    /** @test */
    public function a_user_settings_is_saved_and_retrieved_using_custom_casts()
    {
        $user = create(User::class);

        $this->assertTrue(is_array($user->settings));
    }

    /** @test */
    public function a_user_settings_can_be_set_and_retrieved_like_configurations()
    {
        $user = create(User::class);

        $user->update(['settings' => ['new_entry' => 'leave me alone']]);

        $this->assertEquals('leave me alone', $user->refresh()->settings['new_entry']);
    }

    /** @test */
    public function a_user_has_a_business()
    {
        $user = [
            'name' => $this->faker->firstNameMale . ' ' . $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => '7768907658',
            'business' => $this->faker->company,
            'password' => 'Lambdaxion568',
            'password_confirmation' => 'Lambdaxion568',
        ];

        $this->post(route('register'), $user)->assertRedirect('/home');

        $this->assertInstanceOf(Business::class, user()->business);
    }

    /** @test */
    public function a_user_has_spaces()
    {
        $user = create(User::class);

        $this->assertInstanceOf(Collection::class, $user->spaces);
    }

    /** @test */
    public function a_user_has_an_account()
    {
        $userDetails = [
            'name' => $this->faker->firstNameMale . ' ' . $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => '7768907658',
            'business' => $this->faker->company,
            'password' => 'Lambdaxion568',
            'password_confirmation' => 'Lambdaxion568',
        ];

        $this->post(route('register'), $userDetails)->assertRedirect('/home');

        $this->assertInstanceOf(Account::class, user()->account);
    }
}
