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
        'business' => $faker->company,
        'email' => $faker->email,
        'space_id' => $space->id,
        'user_id' => create(User::class)->id,
        'confirmation_number' => Str::random(7),
        'status' => 'Pending',
        'phone' => $faker->phoneNumber,
        'price' => 100,
        'tax' => 10,
        'service' => 10,
        'subtotal' => 100,
        'total' => 120,
    ];
});
