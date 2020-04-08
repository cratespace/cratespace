<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        // 'avatar' => $faker->image('public/storage/images/person.png', 400, 400),
        'username' => $faker->userName,
        'name' => $faker->firstNameMale . ' ' . $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'type' => 'business',
        'settings' => [
            'notifications_mobile' => 'everything',
            'notifications_email' => [
                'new-order', 'cancel-order', 'newsletter',
            ],
        ],
    ];
});
