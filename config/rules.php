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

    'update_password' => [
        'current_password' => ['required', 'string'],
        'password' => ['required', 'string', new Password(), 'confirmed'],
    ],

    'new_password' => [
        'token' => 'required',
        'email' => ['required', 'email', 'string'],
        'password' => ['required', 'string', new Password(), 'confirmed'],
    ],

    'user_profile' => [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'string'],
        'username' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'min:9'],
        'settings' => ['nullable', 'array'],
        'photo' => ['nullable', 'image', 'max:1024'],
    ],
];
