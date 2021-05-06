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
            'password' => '$2y$10$E8lDpaJXHVVgGNMQJ43hR.A3TLtgD2JYJXLIiK9HLAlHaVaSLxa0a', // alphaxion77
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'settings' => [],
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

        'settings' => [],
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
