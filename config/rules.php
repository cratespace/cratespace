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
        'password' => ['required', 'string', new PasswordRule()],
    ],

    /*
     * Use Profile Information Validation Rules.
     */
    'update_profile' => [
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email'],
        'email' => ['sometimes', 'string', 'regex:/(0)[0-9]{9}/'],
        'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
    ],

    /*
     * User Account Password Update Validation Rules.
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
     * User Business Profile Information Update Validation Rules.
     */
    'business' => [
        'name' => ['required', 'string', 'max:255'],
        'about' => ['nullable', 'string'],
        'photo' => ['sometimes', 'image', 'max:1024'],
        'street' => ['required', 'string', 'max:255'],
        'city' => ['required', 'string', 'max:255'],
        'state' => ['required', 'string', 'max:255'],
        'country' => ['required', 'string', 'max:255'],
        'postcode' => ['required', 'string', 'max:255'],
    ],

    'space' => [
        'code' => ['nullable', 'string', 'max:255', 'unique:spaces,code'],
        'height' => ['required', 'integer'],
        'width' => ['required', 'integer'],
        'length' => ['required', 'integer'],
        'weight' => ['required', 'integer'],
        'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        'tax' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
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
];
