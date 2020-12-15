<?php

namespace App\Features;

class AuthFeatures extends Features
{
    /**
     * Prefix of application category.
     *
     * @var string
     */
    protected static $prefix = 'auth';

    /**
     * Enable user sign in feature.
     *
     * @return string
     */
    public static function signin(): string
    {
        return 'signin';
    }

    /**
     * Enable user sign up feature.
     *
     * @return string
     */
    public static function signup(): string
    {
        return 'signup';
    }

    /**
     * Enable Two Factor Authentication feature.
     *
     * @return string
     */
    public static function twoFactorAuthentication(): string
    {
        return 'two-factor-authentication';
    }

    /**
     * Enable password reset feature.
     *
     * @return string
     */
    public static function passwordReset(): string
    {
        return 'password-reset';
    }

    /**
     * Enable email verification feature.
     *
     * @return string
     */
    public static function emailVerification(): string
    {
        return 'email-verification';
    }

    /**
     * Enable email verification feature.
     *
     * @return string
     */
    public static function passwordConfirmation(): string
    {
        return 'password-confirmation';
    }

    /**
     * Enable other browser sessions management feature.
     *
     * @return string
     */
    public static function otherBrowserSessions(): string
    {
        return 'other-browser-sessions';
    }
}
