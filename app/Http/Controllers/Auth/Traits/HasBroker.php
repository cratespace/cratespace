<?php

namespace App\Http\Controllers\Auth\Traits;

use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;

trait HasBroker
{
    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker(config('auth.defaults.passwords'));
    }
}
