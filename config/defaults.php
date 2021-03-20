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
            'password' => '$2y$10$X71vOqkxROWZBhbWxwvf9eHvN8kFjDmDO5Cjsfk5dIKOKGqkxyWNq', // alphaxion77
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'settings' => [],
            'locked' => false,
            'profile_photo_path' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ],

        'roles' => [
            'Administrator' => [
                'name' => 'Administrator',
                'slug' => 'administrator',
                'description' => 'An administrator has permission to do anything.',
            ],
        ],

        'permissions' => [
            'Administrator' => ['*'],
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
