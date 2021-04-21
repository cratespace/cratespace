<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Support\RecoveryCode;
use Illuminate\Support\Collection;
use App\Events\TwoFactorAuthenticationEnabled;
use App\Contracts\Actions\ProvidesTwoFactorAuthentication;

class EnableTwoFactorAuthentication
{
    /**
     * Default number of recovery codes to be generated.
     *
     * @var int
     */
    protected $numberOfCodes = 8;

    /**
     * The two factor authentication provider.
     *
     * @var \App\Contracts\Actions\ProvidesTwoFactorAuthentication
     */
    protected $provider;

    /**
     * Create a new action instance.
     *
     * @param \App\Contracts\Actions\ProvidesTwoFactorAuthentication $provider
     *
     * @return void
     */
    public function __construct(ProvidesTwoFactorAuthentication $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Enable two factor authentication for the user.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function __invoke(User $user): void
    {
        $user->forceFill([
            'two_factor_secret' => encrypt($this->provider->generateSecretKey()),
            'two_factor_recovery_codes' => $this->generateRecoveryCode(),
        ])->save();

        TwoFactorAuthenticationEnabled::dispatch($user);
    }

    /**
     * Generate new recovery codes for user.
     *
     * @return string
     */
    protected function generateRecoveryCode(): string
    {
        return encrypt(json_encode(
            Collection::times(
                $this->numberOfCodes,
                fn () => RecoveryCode::generate()
            )->all()
        ));
    }
}
