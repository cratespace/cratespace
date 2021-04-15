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
            'password' => '$2y$10$X71vOqkxROWZBhbWxwvf9eHvN8kFjDmDO5Cjsfk5dIKOKGqkxyWNq', // alphaxion77
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'settings' => [
                'notificaions' => ['web', 'email', 'sms'],
            ],
            'address' => [
                'street' => '59, Martin Road',
                'city' => 'Jaffna',
                'state' => 'Northern Province',
                'country' => 'Sri Lanka',
            ],
            'locked' => false,
            'profile_photo_path' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ],

        'profile' => [
            'type' => 'standard',
            'business' => 'Cratesapce, Inc.',
            'email' => 'hello@cratespace.biz',
            'phone' => '0775018795',
            'registration_number' => 01234567,
            'country' => 'Sri Lanka',
            'business_type' => 'company',
            'business_profile' => [
                'name' => 'Cratesapce, Inc.',
                'mcc' => 4799,
                'support_phone' => '0775018795',
                'support_email' => 'support@cratespace.biz',
                'url' => 'https://cratesapce.biz',
            ],
        ],

        'roles' => [
            /*
             * An administrator has permission to do anything.
             */
            'Administrator' => [
                'name' => 'Administrator',
                'slug' => 'administrator',
                'description' => 'An administrator has permission to do anything.',
            ],

            /*
             * Business users can manage spaces and orders aswell as purchase spaces.
             */
            'Business' => [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Business users can manage spaces and orders aswell as purchase spaces.',
            ],

            /*
            * Customers can only purchase spaces.
            */
            'Customer' => [
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Customers can only purchase spaces.',
            ],
        ],

        'permissions' => [
            'Administrator' => ['*'],
        ],

        'settings' => [
            'notifications' => ['web', 'email', 'sms'],
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
