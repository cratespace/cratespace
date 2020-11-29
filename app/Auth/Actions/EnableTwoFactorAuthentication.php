<?php

namespace App\Auth\Actions;

use App\Auth\RecoveryCode;
use Illuminate\Support\Collection;
use App\Contracts\Auth\TwoFactorAuthenticator;

class EnableTwoFactorAuthentication
{
    /**
     * The two factor authentication authenticator.
     *
     * @var \App\Contracts\Auth\TwoFactorAuthenticator
     */
    protected TwoFactorAuthenticator $authenticator;

    /**
     * Create a new action instance.
     *
     * @param \App\Contracts\Auth\TwoFactorAuthenticator $authenticator
     *
     * @return void
     */
    public function __construct(TwoFactorAuthenticator $authenticator)
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
