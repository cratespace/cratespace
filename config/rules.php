<?php

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\User;
use Cratespace\Sentinel\Rules\PasswordRule;

return [
    /*
     * Password Input Validation Rules.
     */
    'password' => ['required', 'string', new PasswordRule(), 'confirmed'],

    /*
     * User Login Validation Rules.
     */
    'login' => [
        'email' => ['sometimes', 'string', 'email'],
        'password' => ['required', 'string'],
        'remember' => ['sometimes'],
    ],

    /*
     * Customer Registration Validation Rules.
     */
    'register' => [
        'name' => ['required', 'string', 'max:255'],
        'business' => ['exclude_if:type,customer', 'string', 'max:255'],
        'phone' => ['sometimes', 'string', 'regex:/(07)[0-9]{8}/'],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique(User::class),
        ],
        'password' => ['required', 'string', new PasswordRule()],
        'type' => ['sometimes', 'string', Rule::in(['business', 'customer'])],
    ],

    /*
     * Business User Input Validation Rules.
     */
    'business' => [
        'registration_number' => ['required', 'string', 'max:255'],
        'mcc' => ['required', 'string', 'max:255'],
        'url' => ['required', 'url', 'string', 'max:255'],
        'invite' => ['sometimes', 'accepted'],
    ],

    /*
     * Address Inputs Validation Rules.
     */
    'address' => [
        'line1' => ['required', 'string', 'max:255'],
        'city' => ['required', 'string', 'max:255'],
        'state' => ['required', 'string', 'max:255'],
        'country' => ['required', 'string', 'max:255'],
    ],

    /*
     * Use Profile Information Validation Rules.
     */
    'update_profile' => [
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email'],
        'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
    ],

    /*
     * Use Account Password Update Validation Rules.
     */
    'update_password' => [
        'current_password' => ['required', 'string'],
        'password' => [
            'required',
            'string',
            new PasswordRule(),
            'confirmed',
            'different:current_password',
        ],
    ],

    /*
     * Business Invitaion Parameters Validation Rules.
     */
    'invitation' => [
        'email' => ['required', 'email', 'unique:invitations,email'],
        'role' => ['required', 'string', Rule::in(['Business', 'Administrator'])],
    ],
];
