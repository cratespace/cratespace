<?php

return [
    /*
     * Administrator users can perform any action.
     */
    [
        'name' => 'Administrator',
        'slug' => 'administrator',
        'description' => 'Administrator users can perform any action.',
    ],

    /*
     * Business users can manage spaces and orders aswell as purchase spaces.
     */
    [
        'name' => 'Business',
        'slug' => 'business',
        'description' => 'Business users can manage spaces and orders aswell as purchase spaces.',
    ],

    /*
     * Customers can only purchase spaces.
     */
    [
        'name' => 'Customer',
        'slug' => 'customer',
        'description' => 'Customers can only purchase spaces.',
    ],
];
