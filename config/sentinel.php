<?php

use App\Providers\RouteServiceProvider;

return [
    /*
     * Authentication Guard.
     */

    'guard' => 'web',

    /*
     * Sentinel Password Broker.
     */
    'passwords' => 'users',

    /*
     * Username / Email.
     */
    'username' => 'email',
    'email' => 'email',

    /*
     * Home Path.
     */
    'home' => RouteServiceProvider::HOME,

    /*
     * Sentinel Routes Prefix / Subdomain.
     */
    'prefix' => '',
    'domain' => null,

    /*
     * Sentinel Routes Middleware
     */
    'middleware' => ['web'],

    /*
     * Rate Limiting.
     */
    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    /*
     * Register View Routes.
     */
    'views' => true,

    /*
     * Stateful Domains.
     */
    'stateful' => explode(',', env(
        'SANCTUM_STATEFUL_DOMAINS',
        'preflight.test,localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1'
    )),

    /*
     * Expiration Minutes.
     */
    'expiration' => null,

    /*
     * API Middleware.
     *
     * When authenticating your first-party SPA with API you may need to
     * customize some of the middleware API uses while processing the
     * request. You may change the middleware listed below as required.
     */
    'stateful_middleware' => [
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
    ],
];
