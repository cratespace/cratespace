<?php

namespace App\Auth\TwoFactorAuthentication;

use Illuminate\Support\Collection;
use App\Contracts\Auth\TwoFactorAuthenticationProvider;
use Facades\App\Auth\TwoFactorAuthentication\RecoveryCode;

class EnableTwoFactorAuthentication
{
    /**
     * The two factor authentication provider.
     *
     * @var \App\Contracts\Auth\TwoFactorAuthenticationProvider
     */
    protected $provider;

    /**
     * Create a new action instance.
     *
     * @param \App\Contracts\Auth\TwoFactorAuthenticationProvider $provider
     *
     * @return void
     */
    public function __construct(TwoFactorAuthenticationProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Enable two factor authentication for the user.
     *
     * @param mixed $user
     *
     * @return void
     */
    public function __invoke($user): void
    {
        $user->forceFill([
            'two_factor_secret' => encrypt($this->provider->generateSecretKey()),
            'two_factor_recovery_codes' => encrypt(json_encode(Collection::times(8, function () {
                return RecoveryCode::generate();
            })->all())),
        ])->save();
    }
}
