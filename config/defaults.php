<?php

return [
    /*
     * App Billing Configurations.
     */
    'billing' => [
        /*
         * Billing Units.
         */
        'currency' => env('APP_CURRENCY'),
        'currency_locale' => env('APP_CURRENCY_LOCALE'),
        'transaction-description' => 'Cratespace test purchase.',

        /*
         * Default Chargeable Amounts.
         */
        'charges' => [
            'service' => 0.03,
            'tax' => 0.01,
        ],

        /*
         * Charges Calculation Classes.
         */
        'calculations' => [
            // \App\Billing\Charges\Calculations\VATCalculation::class
        ],
    ],

    /*
     * Default/Admin User Details.
     */
    'user' => [
        'username' => 'Thavarshan',
        'name' => 'Thavarshan Thayananthajothy',
        'email' => 'tjthavarshan@gmail.com',
        'phone' => '775018795',
        'email_verified_at' => now(),
        'password' => '$2y$10$8jakkFVc8175VAOGK5Jt/uDT4R9KEwJPdG5jEEceaxCHwyfhkLs2S', // alphaxion77
        'remember_token' => 'Wdd5eAC4tFBrM0c4qT1b1yGrePdlBzONsndKxjEx',
        'settings' => [
            'notifications_mobile' => 'everything',
            'notifications_email' => [
                'new-order', 'cancel-order', 'newsletter',
            ],
        ],
    ],

    /*
     * Default Business Details of Default User.
     */
    'business' => [
        'name' => 'Cratespace',
        'slug' => 'cratespace',
        'description' => 'This is mine.',
        'street' => '59 Martin Road',
        'city' => 'Jaffna',
        'state' => 'Northern',
        'country' => 'Sri Lanka',
        'postcode' => 40000,
        'email' => 'tjthavarshan@gmail.com',
        'phone' => '775018795',
    ],

    /*
     * Default Space Module Details.
     */
    'spaces' => [
        'types' => [
            'Local',
            'International',
        ],
    ],

    /*
     * Default Order Placement & Management Details.
     */
    'orders' => [
        'statuses' => [
            'Pending',
            'Approved',
            'Rejected',
            'Shipped',
            'Delivered',
            'Completed',
        ],
    ],
];
