<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserLoginTest extends DuskTestCase
{
    /** @test */
    public function a_business_user_can_login_successfully()
    {
        $user = $this->signIn(create(User::class, [
            'email' => 'john@doe.com',
            'password' => Hash::make('supersecretpassword'),
        ]));

        Auth::logout();

        $this->assertDatabaseHas('users', ['email' => 'john@doe.com']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'supersecretpassword')
                ->press('Sign in')
                ->assertPathIs('/home')
                ->assertSee($user->business->email)
                ->visit('/logout')->logout();
        });
    }

    /** @test */
    public function a_business_user_cannot_login_with_invalid_credentials()
    {
        $user = $this->signIn(create(User::class, [
            'email' => 'john@doe.com',
            'password' => Hash::make('supersecretpassword'),
        ]));

        Auth::logout();

        $this->assertDatabaseHas('users', ['email' => 'john@doe.com']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'notsosupersecretpassword')
                ->press('Sign in')
                ->assertPathIs('/login')
                ->assertSee('credentials do not match');
        });
    }
}
