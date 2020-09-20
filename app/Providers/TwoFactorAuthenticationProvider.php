<?php

namespace App\Providers;

use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use App\Contracts\Auth\TwoFactorAuthenticationProvider as TwoFactorAuthenticationProviderContract;

class TwoFactorAuthenticationProvider extends ServiceProvider implements TwoFactorAuthenticationProviderContract
{
    /**
     * The underlying library providing two factor authentication helper services.
     *
     * @var \PragmaRX\Google2FA\Google2FA
     */
    protected $engine;

    /**
     * Create a new two factor authentication provider instance.
     *
     * @param \PragmaRX\Google2FA\Google2FA $engine
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->engine = $this->app->make(Google2FA::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(TwoFactorAuthenticationProviderContract::class, $this);
    }

    /**
     * Generate a new secret key.
     *
     * @return string
     */
    public function generateSecretKey(): string
    {
        return $this->engine->generateSecretKey();
    }

    /**
     * Get the two factor authentication QR code URL.
     *
     * @param string $companyName
     * @param string $companyEmail
     * @param string $secret
     *
     * @return string
     */
    public function qrCodeUrl(string $companyName, string $companyEmail, string $secret): string
    {
        return $this->engine->getQRCodeUrl($companyName, $companyEmail, $secret);
    }

    /**
     * Verify the given code.
     *
     * @param string $secret
     * @param string $code
     *
     * @return bool
     */
    public function verify(string $secret, string $code): bool
    {
        return $this->engine->verifyKey($secret, $code);
    }
}
