<?php

namespace App\Auth\TwoFactorAuthentication;

class DisableTwoFactorAuthentication
{
    /**
     * Disable two factor authentication for the user.
     *
     * @param mixed $user
     *
     * @return void
     */
    public function __invoke($user): void
    {
        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ])->save();
    }
}
