<?php

return [
    /*
     * Default/Admin User Details
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

    'business' => [
        'name' => 'Cratespace',
        'slug' => 'cratespace',
        'description' => 'Nullam id dolor id nibh ultricies vehicula ut id elit.',
        'street' => '22 Auburn Side',
        'city' => 'Sri Lanka',
        'state' => 'Western',
        'country' => 'Sri Lanka',
        'postcode' => 13500,
        'email' => 'tjthavarshan@gmail.com',
        'phone' => '775018794',
    ],
];
