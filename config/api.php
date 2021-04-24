<?php

return [
    /*
     * Stateful Domains.
     */
    'stateful' => explode(',', env(
        'API_STATEFUL_DOMAINS',
        'cratespace.test,localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1'
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
