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
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'settings' => [],
            'locked' => false,
            'profile_photo_path' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ],

        /*
         * All Permissions A User Can Have...
         */
        'permissions' => [
            'administrator:*',
            'customer:purchase',
            'customer:cancel_order',
            'business:add_space',
            'business:edit_space',
            'business:delete_space',
            'business:approve_order',
            'business:complete_order',
            'business:cancel_order',
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
