<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Auth\Actions\UpdateUserPassword;
use App\Contracts\Auth\UpdatesUserPasswords;

class UpdateUserPasswordActionTest extends TestCase
{
    /** @test */
    public function it_addheres_to_common_interface()
    {
        $updator = new UpdateUserPassword();

        $this->assertInstanceOf(UpdatesUserPasswords::class, $updator);
    }

    /** @test */
    public function it_can_update_given_users_password()
    {
        $user = create(User::class);
        $userPassword = $user->password;
        $updator = new UpdateUserPassword();

        $updator->update($user, [
            'password' => 'NinjaWarrior547',
        ]);

        $this->assertNotEquals($userPassword, $user->fresh()->password);
    }
}
