<?php

namespace App\Auth\TwoFactorAuthentication;

use Illuminate\Support\Collection;

class GenerateNewRecoveryCodes
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
            'two_factor_recovery_codes' => encrypt(json_encode(Collection::times(8, function () {
                return RecoveryCode::generate();
            })->all())),
        ])->save();
    }
}
