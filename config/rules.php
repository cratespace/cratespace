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
     * Use Registration Validation Rules.
     */
    'register' => [
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique(User::class),
        ],
        'phone' => ['required', 'numeric', 'regex:/(07)[0-9]{8}/'],
        'password' => ['required', 'string', new PasswordRule()],
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
];
