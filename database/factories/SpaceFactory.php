<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Space;
use App\Models\Business;
use Faker\Generator as Faker;

$factory->define(Space::class, function (Faker $faker) {
    $user = create(User::class);

    create(Business::class, [
        'user_id' => $user->id,
        'country' => 'Sri Lanka',
    ]);

    $price = rand(1, 9);

    return [
        'uid' => Str::random(12),
        'departs_at' => now()->addMonths(rand(1, 500)),
        'arrives_at' => now()->addMonths(rand(1, 1000)),
        'origin' => $faker->city,
        'destination' => $faker->city,
        'height' => rand(1, 9),
        'width' => rand(1, 9),
        'length' => rand(1, 9),
        'weight' => rand(1, 9),
        'note' => $faker->sentence(7),
        'price' => rand(1, 9),
        'tax' => $price * 0.5, // 50% tax
        'type' => $faker->randomElement(['Local', 'International']),
        'base' => 'Sri Lanka',
        'user_id' => $user->id,
    ];
});
