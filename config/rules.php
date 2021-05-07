<?php

use App\Rules\ChargeRule;
use App\Rules\DestinationRule;
use App\Rules\PhoneNumberRule;
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
        'business' => ['exclude_if:type,customer', 'string', 'max:255'],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique(User::class),
        ],
        'phone' => ['sometimes', 'string', new PhoneNumberRule()],
        'password' => ['required', 'string', new PasswordRule(), 'confirmed'],
        'type' => ['sometimes', 'string', Rule::in(['business', 'customer'])],
    ],

    /*
     * Business User Input Validation Rules.
     */
    'business' => [
        'registration_number' => [
            'required',
            'max:255',
            'unique:businesses,registration_number',
        ],
        'mcc' => [
            'nullable',
            'string',
            'max:255',
            'unique:businesses,mcc',
        ],
        'url' => ['sometimes', 'url', 'string', 'max:255'],
        'invite' => ['sometimes'],
    ],

    /*
     * Use Profile Information Validation Rules.
     */
    'update_profile' => [
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email'],
        'phone' => ['sometimes', 'string', new PhoneNumberRule()],
        'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
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
    ],

    /*
     * Create/Update Space Details Validation Rules...
     */
    'space' => [
        'code' => ['nullable', 'string', 'max:255', 'unique:spaces,code'],
        'height' => ['required', 'numeric'],
        'width' => ['required', 'numeric'],
        'length' => ['required', 'numeric'],
        'weight' => ['required', 'numeric'],
        'price' => ['required', 'numeric', new ChargeRule()],
        'tax' => ['nullable', 'numeric', new ChargeRule()],
        'origin' => ['required', 'string', new DestinationRule()],
        'destination' => ['required', 'string', new DestinationRule()],
        'departs_at' => ['required', 'date'],
        'arrives_at' => ['required', 'date', 'after:departs_at'],
        'note' => ['nullable', 'string'],
        'type' => [
            'required', 'string',
            Rule::in(['Local', 'International']),
        ],
        'base' => ['sometimes', 'string'],
        'user_id' => ['required', 'integer', 'exists:users,id'],
    ],

    /*
     * Purchase (purchase space) Validation Rules...
     */
    'order' => [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email'],
        'phone' => ['sometimes', 'string', new PhoneNumberRule()],
        'business' => ['sometimes', 'string', 'max:255'],
        'payment_method' => ['required', 'string'],
        'customer' => ['required', 'string'],
    ],
];
