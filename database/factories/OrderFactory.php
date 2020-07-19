<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\Space;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $space = create(Space::class);

    return [
        'name' => $faker->name,
        'business' => $faker->company,
        'email' => $faker->email,
        'space_id' => $space->id,
        'phone' => $faker->phoneNumber,
        'price' => $space->getPriceInCents(),
        'tax' => $space->getTaxInCents(),
    ];
});
