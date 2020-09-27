<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Auth\Actions\ResetUserPassword;
use App\Contracts\Auth\ResetsUserPasswords;

class ResetUserPasswordActionTest extends TestCase
{
    /** @test */
    public function it_addheres_to_common_interface()
    {
        $updator = new ResetUserPassword();

        $this->assertInstanceOf(ResetsUserPasswords::class, $updator);
    }

    /** @test */
    public function it_can_reset_given_users_password()
    {
        $user = create(User::class);
        $userPassword = $user->password;
        $resetor = new ResetUserPassword();

        $resetor->reset($user, [
            'password' => 'NinjaWarrior547',
        ]);

        $this->assertNotEquals($userPassword, $user->fresh()->password);
    }
}
