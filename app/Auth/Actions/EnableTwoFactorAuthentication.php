<?php

namespace App\Auth\Actions;

use App\Auth\RecoveryCode;
use Laravel\Fortify\RecoveryCode;
use Illuminate\Support\Collection;
use App\Contracts\Auth\TwoFactorAuthentication;

class EnableTwoFactorAuthentication
{
    /**
     * The two factor authentication authenticator.
     *
     * @var \App\Contracts\Auth\TwoFactorAuthentication
     */
    protected TwoFactorAuthentication $authenticator;

    /**
     * Create a new action instance.
     *
     * @param \App\Contracts\Auth\TwoFactorAuthentication $authenticator
     *
     * @return void
     */
    public function __construct(TwoFactorAuthentication $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * Enable two factor authentication for the user.
     *
     * @param mixed $user
     *
     * @return void
     */
    public function __invoke($user)
    {
        $user->forceFill([
            'two_factor_secret' => encrypt($this->authenticator->generateSecretKey()),
            'two_factor_recovery_codes' => encrypt(json_encode(Collection::times(8, function () {
                return RecoveryCode::generate();
            })->all())),
        ])->save();
    }
}
