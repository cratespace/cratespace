<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Auth\Actions\CreateNewUser;

class CreateUserTest extends TestCase
{
    /** @test */
    public function it_can_create_a_new_user_from_the_given_details()
    {
        $userCreator = new CreateNewUser();
        $user = $userCreator->create([
            'name' => 'John Vox Doe',
            'email' => 'john.vodo@sunnyside.com',
            'password' => 'CattleFarmer97',
            'business' => 'Sunny Side Exporters',
            'phone' => '91-0292-my-bum',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->business->exists());
        $this->assertEquals('Sunny Side Exporters', $user->business->name);
        $this->assertTrue($user->account->exists());
        $this->assertEquals(0, $user->account->credit);
        $this->assertDatabaseHas('users', [
            'name' => 'John Vox Doe',
            'email' => 'john.vodo@sunnyside.com',
            'phone' => '91-0292-my-bum',
        ]);
    }
}
