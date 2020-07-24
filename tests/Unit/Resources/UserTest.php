<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Models\Business;
use Illuminate\Support\Collection;

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
