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
            'password' => '$2y$10$p2s6IMWuZ9hW5WyfyTtfX.DyYIoWxslklzI7ZNiwfeXtZ.Lp4qoJe', // password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'settings' => [],
            'locked' => false,
            'profile_photo_path' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ],

        'business' => [
            'name' => 'Cratespace, Inc.',
            'about' => 'A freight space sales platform.',
            'street' => '59 Martin Road',
            'city' => 'Jaffna',
            'state' => 'Northern Province',
            'country' => 'Sri Lanka',
            'postcode' => '40000',
        ]
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
