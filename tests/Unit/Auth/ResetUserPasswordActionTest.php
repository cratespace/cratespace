<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use App\Auth\Actions\ResetUserPassword;
use Illuminate\Auth\Events\PasswordReset;
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

        $resetor->reset($user, 'NinjaWarrior547');

        $this->assertNotEquals($userPassword, $user->fresh()->password);
    }

    /** @test */
    public function it_fires_an_event_everytime_a_user_resets_password()
    {
        Event::fake();

        $user = create(User::class);
        $userPassword = $user->password;
        $resetor = new ResetUserPassword();

        $resetor->reset($user, 'NinjaWarrior547');

        Event::assertDispatched(PasswordReset::class);
    }

    /** @test */
    public function it_automatically_logs_the_user_in_after_resetting_the_password()
    {
        $user = create(User::class);
        $userPassword = $user->password;
        $resetor = new ResetUserPassword();

        $resetor->reset($user, 'NinjaWarrior547');

        $this->assertTrue(auth()->user()->is($user));
    }
}
