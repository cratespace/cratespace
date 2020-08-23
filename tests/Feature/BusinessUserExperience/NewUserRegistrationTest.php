<?php

namespace Tests\Feature\BusinessUserExperience;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Models\Business;

class NewUserRegistrationTest extends TestCase
{
    /** @test */
    public function a_new_logistics_business_can_create_an_account()
    {
        $userDetails = [
            'name' => 'John Vox Doe',
            'email' => 'john.vodo@sunnyside.com',
            'password' => 'CattleFarmer97',
            'password_confirmation' => 'CattleFarmer97',
            'business' => 'Sunny Side Exporters',
            'phone' => '91-0292-my-bum',
        ];

        $response = $this->post('/register', $userDetails)
            ->assertStatus(302)
            ->assertRedirect('/home');

        $user = User::whereName('John Vox Doe')->first();

        $this->assertDatabaseHas('users', [
            'name' => 'John Vox Doe',
            'email' => 'john.vodo@sunnyside.com',
            'phone' => '91-0292-my-bum',
        ]);
        $this->assertDatabaseHas('businesses', ['name' => 'Sunny Side Exporters']);
        $this->assertDatabaseHas('accounts', ['credit' => 0]);
        $this->assertEquals($user->business->name, 'Sunny Side Exporters');
        $this->assertInstanceOf(Business::class, $user->business);
        $this->assertEquals($user->account->credit, 0);
        $this->assertInstanceOf(Account::class, $user->account);
    }
}
