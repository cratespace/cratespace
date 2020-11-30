<?php

namespace App\Auth;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use App\Contracts\Auth\Authenticator as AuthenticatorContract;
use App\Contracts\Auth\TwoFactorAuthenticator as TwoFactorAuthenticatorContract;

class TwoFactorAuthenticator implements AuthenticatorContract, TwoFactorAuthenticatorContract
{
    /**
     * The underlying library providing two factor authentication helper services.
     *
     * @var \PragmaRX\Google2FA\Google2FA
     */
    protected Google2FA $engine;

    /**
     * Create a new two factor authentication provider instance.
     *
     * @param \PragmaRX\Google2FA\Google2FA $engine
     *
     * @return void
     */
    public function __construct(Google2FA $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Handle given login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function authenticate(Request $request)
    {
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
