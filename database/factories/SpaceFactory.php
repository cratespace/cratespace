<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Space;
use App\Models\Account;
use App\Models\Business;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Space::class, function (Faker $faker) {
    $user = create(User::class);

    $business = create(Business::class, [
        'user_id' => $user->id,
        'country' => 'Sri Lanka',
    ]);

    create(Account::class, [
        'user_id' => $user->id,
    ]);

    $price = rand(100, 900);

    return [
        'code' => strtoupper(Str::random(12)),
        'departs_at' => now()->addMonths(rand(1, 3)),
        'arrives_at' => now()->addMonths(rand(2, 3)),
        'reserved_at' => null,
        'origin' => $faker->city,
        'destination' => $faker->city,
        'height' => rand(1, 9),
        'width' => rand(1, 9),
        'length' => rand(1, 9),
        'weight' => rand(1, 9),
        'note' => $faker->sentence(7),
        'price' => $price,
        'tax' => round($price * 0.05), // 5% tax
        'type' => $faker->randomElement(['Local', 'International']),
        'user_id' => $user->id,
        'base' => $business->country,
    ];
});
