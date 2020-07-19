<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\Space;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'space_id' => create(Space::class)->id,
    ];
});
