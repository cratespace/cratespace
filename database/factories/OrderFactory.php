<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $space = create(Space::class);

    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'space_id' => $space->id,
        'user_id' => $space->user->id,
        'total' => 11.5,
        'tax' => 0.5,
        'service' => 1.0,
        'status' => $faker->randomElement(['Pending', 'Confirmed', 'Completed']),
    ];
});
