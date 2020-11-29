<?php

use App\Models\User;
use App\Rules\Password;
use Illuminate\Validation\Rule;
use App\Providers\AuthServiceProvider;

$username = AuthServiceProvider::USERNAME;

return [
    'signup' => [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'string', 'max:255', Rule::unique(User::class)],
        'phone' => ['required', 'string'],
        'business' => ['sometimes', 'required', 'string', 'max:255'],
        'password' => ['required', 'string', new Password(), 'confirmed'],
    ],

    'signin' => [
        $username => ['required', 'string', $username === 'email' ? 'email' : null],
        'password' => ['required', 'string'],
    ],

    'tfa_signin' => [
        'code' => ['nullable', 'string'],
        'recovery_code' => ['nullable', 'string'],
    ],
];
