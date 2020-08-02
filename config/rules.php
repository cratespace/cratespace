<?php

/**
 * All Validation Rules.
 */
return [
    /*
     * User Inputs Rules
     */
    'user' => [
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255'],
        'business' => ['nullable', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'phone' => ['required', 'string', 'min:9'],
    ],

    /*
     * User Password Reset Inputs Rules
     */
    'user-password' => [
        'password' => ['required', 'string', 'min:8', 'confirmed', 'different:old_password'],
        'password_confirmation' => ['required', 'string', 'min:8'],
    ],

    /*
     * Spaces Inputs Rules
     */
    'space' => [
        'uid' => ['required', 'string', 'max:255'],
        'height' => ['required', 'integer'],
        'width' => ['required', 'integer'],
        'length' => ['required', 'integer'],
        'weight' => ['required', 'integer'],
        'price' => ['required', 'numeric', 'min:1'],
        'origin' => ['required', 'string'],
        'destination' => ['required', 'string'],
        'departs_at' => ['required', 'date'],
        'arrives_at' => ['required', 'date', 'after:departs_at'],
        'note' => ['nullable', 'string'],
        'type' => ['required', 'string'],
        'base' => ['required', 'string'],
    ],

    /*
     * Order Inputs Rules
     */
    'order' => [
        'email' => ['required', 'string', 'email', 'max:255'],
        'payment_token' => ['required', 'string'],
    ],

    /*
     * Client Message Inputs Rules
     */
    'message' => [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'phone' => ['required', 'integer', 'min:9'],
        'subject' => ['required', 'string', 'max:255'],
        'body' => ['required', 'string'],
    ],

    /*
     * User Business Inputs Rules
     */
    'business' => [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'phone' => ['required', 'integer', 'min:9'],
        'description' => ['nullable', 'string'],
    ],

    /*
     * Address Inputs Rules
     */
    'address' => [
        'street' => ['required', 'string'],
        'state' => ['required', 'string'],
        'city' => ['required', 'string'],
        'country' => ['required', 'string'],
    ],

    /*
     * Registration Inputs Rules
     */
    'registration' => [
        'name' => ['required', 'string', 'max:255'],
        'business' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone' => ['required', 'string', 'min:9'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ],
];
