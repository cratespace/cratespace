<?php

namespace App\Auth\Actions;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use App\Contracts\Auth\ResetsUserPasswords;
use App\Auth\Actions\Traits\UpdatesPassword;

class ResetUserPassword implements ResetsUserPasswords
{
    use UpdatesPassword;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param \App\Models\User $user
     * @param string           $password
     *
     * @return void
     */
    public function reset(User $user, string $password): void
    {
        $this->updatePassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        Auth::guard()->login($user);
    }
}
