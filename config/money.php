<?php

return [
    /*
     * Stripe Keys.
     */
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),

    /*
     * Stripe Webhooks.
     *
     * Your Stripe webhook secret is used to prevent unauthorized requests to
     * your Stripe webhook handling controllers. The tolerance setting will
     * check the drift between the current time and the signed request's.
     */
    'webhook' => [
        'secret' => env('STRIPE_WEBHOOK_SECRET'),
        'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
    ],

    /*
     * Currency.
     */
    'currency' => env('APP_CURRENCY', 'usd'),

    /*
     * Currency Locale.
     */
    'currency_locale' => env('APP_CURRENCY_LOCALE', 'en'),

    /*
     * Invoice Paper Size.
     *
     * Supported sizes: 'letter', 'legal', 'A4'.
     */
    'paper' => env('INVOICE_PAPER', 'A4'),
];
