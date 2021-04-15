<?php

use App\Rules\PasswordRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\User;

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
        'password' => ['required', 'string', new PasswordRule(), 'confirmed'],
        'type' => ['sometimes', 'string', Rule::in(['business', 'customer'])],
    ],

    /*
     * Business User Input Validation Rules.
     */
    'business' => [
        'registration_number' => [
            'required',
            'string',
            'max:255',
            'unique:businesses,registration_number',
        ],
        'mcc' => [
            'required',
            'string',
            'max:255',
            'unique:businesses,mcc',
        ],
        'url' => ['sometimes', 'url', 'string', 'max:255'],
        'invite' => ['sometimes'],
    ],

    /*
     * Address Inputs Validation Rules.
     */
    'address' => [
        'line1' => ['required', 'string', 'max:255'],
        'city' => ['required', 'string', 'max:255'],
        'state' => ['required', 'string', 'max:255'],
        'country' => ['required', 'string', 'max:255'],
        'postal_code' => ['required', 'string', 'max:255'],
    ],

    /*
     * Use Profile Information Validation Rules.
     */
    'update_profile' => [
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email'],
        'phone' => ['sometimes', 'string', 'regex:/(0)[0-9]{9}/'],
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
        'role' => [
            'required',
            'string',
            Rule::in(['Business', 'Administrator']),
        ],
    ],

    /*
     * Create/Update Space Details Validation Rules...
     */
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
        'base' => ['sometimes', 'string'],
    ],

    /*
     * Purchase (purchase space) Validation Rules...
     */
    'order' => [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email'],
        'phone' => ['sometimes', 'string', 'regex:/(0)[0-9]{9}/'],
        'business' => ['sometimes', 'string', 'max:255'],
        'payment_method' => ['required', 'string'],
        'customer' => ['required', 'string'],
    ],
];
