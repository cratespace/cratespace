<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Models\Business;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class UserTest extends TestCase
{
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
            'type' => 'business'
        ];

        $this->post(route('register'), $user)
             ->assertRedirect('/home');

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
        $user = [
            'name' => $this->faker->firstNameMale . ' ' . $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => '7768907658',
            'business' => $this->faker->company,
            'password' => 'Lambdaxion568',
            'password_confirmation' => 'Lambdaxion568',
            'type' => 'business'
        ];

        $this->post(route('register'), $user)
             ->assertRedirect('/home');

        $this->assertInstanceOf(Account::class, user()->account);
    }

    /** @test */
    public function only_user_of_type_admin_can_access_admin_dashboard()
    {
        $this->signIn(create(User::class, ['type' => 'business']));

        $this->get('/home')->assertStatus(200);

        auth()->logout();

        $adminUser = $this->signIn(create(User::class, ['type' => 'admin']));

        $this->get('/home')->assertRedirect('/admin');
    }
}
