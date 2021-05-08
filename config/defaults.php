<?php

use Illuminate\Support\Str;

return [
    /*
     * Default User Related Settings and Details...
     */
    'users' => [
        'credentials' => [
            'name' => 'Thavarshan Thayananthajothy',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'phone' => '0775018795',
            'password' => '$2y$10$E8lDpaJXHVVgGNMQJ43hR.A3TLtgD2JYJXLIiK9HLAlHaVaSLxa0a', // alphaxion77
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'settings' => [
                'notifications' => ['mail', 'database'],
            ],
            'address' => [
                'line1' => '4431 Birch Street',
                'city' => 'Greenwood',
                'state' => 'Indiana',
                'country' => 'United States',
                'postal_code' => '46142',
            ],
            'locked' => false,
            'profile_photo_path' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ],

        'settings' => [
            'notifications' => ['mail', 'database'],
        ],

        'business' => [
            'name' => 'Cratespace, Inc.',
            'email' => 'info@cratespace.biz',
            'phone' => '0117100200',
            'registration_number' => 'FTD64578HYU',
            'type' => 'standard',
            'business_type' => 'company',
            'mcc' => '6785234',
        ],

        'customer' => [
            'service_id' => 'cus_JRk3j80RH7qsOr',
        ],
    ],

    /*
     * Default API Related Details...
     */
    'api' => [
        'permissions' => [
            'create',
            'read',
            'update',
            'delete',
        ],
    ],
];
