<?php

use App\Billing\Gateways\FakePaymentGateway;
use App\Billing\Gateways\StripePaymentGateway;

return [
    'defaults' => [
        'service' => 'stripe',
    ],

    'services' => [
        'fake' => [
            'key' => env('APP_KEY'),
            'gateway' => FakePaymentGateway::class,
        ],

        'stripe' => [
            'enabled' => false,
            'key' => env('STRIPE_KEY'),
            'secret' => env('STRIPE_SECRET'),
            'account' => env('STRIPE_ACCOUNT'),
            'client_id' => env('STRIPE_CLIENT_ID'),
            'logger' => env('BILLING_LOGGER'),
            'gateway' => StripePaymentGateway::class,
        ],

        'paddle' => [
            'vendor_id' => env('PADDLE_VENDOR_ID'),
            'vendor_auth_code' => env('PADDLE_VENDOR_AUTH_CODE'),
            'public_key' => env('PADDLE_PUBLIC_KEY'),
        ],

        'mollie' => [],
    ],

    'currency' => env('BILLING_CURRENCY', 'usd'),

    'currency_locale' => env('BILLING_CURRENCY_LOCALE', 'en'),

    'paper' => env('BILLING_PAPER', 'letter'),

    'service_charge' => 0.03, // 3%

    'key_words' => [
        'price',
        'tax',
        'subtotal',
        'service',
        'total',
    ],
];
