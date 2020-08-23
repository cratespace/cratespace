<?php

use Illuminate\Validation\Rule;

/*
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
        'code' => ['nullable', 'string', 'max:255', 'unique:spaces,code'],
        'height' => ['required', 'integer'],
        'width' => ['required', 'integer'],
        'length' => ['required', 'integer'],
        'weight' => ['required', 'integer'],
        'price' => ['required', 'numeric'],
        'tax' => ['nullable', 'numeric'],
        'origin' => ['required', 'string'],
        'destination' => ['required', 'string'],
        'departs_at' => ['required', 'date'],
        'arrives_at' => ['required', 'date', 'after:departs_at'],
        'note' => ['nullable', 'string'],
        'type' => [
            'required', 'string',
            Rule::in(['Local', 'International']),
        ],
        'base' => ['required', 'string'],
    ],

    /*
     * Order Inputs Rules
     */
    'order' => [
        'name' => ['required', 'string', 'max:255'],
        'business' => ['nullable', 'string', 'max:255'],
        'phone' => ['required', 'integer', 'min:9'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'payment_token' => ['nullable', 'string'],
    ],

    /*
     * Client Message Inputs Rules
     */
    'message' => [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'phone' => ['required', 'integer', 'min:9'],
        'subject' => ['required', 'string', 'max:255'],
        'body' => ['required', 'string'],
    ],

    /*
     * Client Message Inputs Rules
     */
    'ticket' => [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'phone' => ['required', 'integer', 'min:9'],
        'subject' => ['required', 'string', 'max:255'],
        'message' => ['required', 'string'],
        'attachment' => ['nullable', 'image'],
        'user_id' => ['nullable', 'integer'],
    ],

    /*
     * Support Ticket Reply Inputs Rules
     */
    'reply' => [
        'body' => ['required', 'spamfree']
    ]

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
