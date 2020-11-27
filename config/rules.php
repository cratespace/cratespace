<?php

use App\Models\User;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

return [
    'register' => [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
        'business' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'min:9'],
        'password' => ['required', 'string', new Password(), 'confirmed'],
    ],
];
