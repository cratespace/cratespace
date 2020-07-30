<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\Space;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $space = create(Space::class);
    $service = $space->getPriceInCents() * config('charges.service');

    return [
        'uid' => Str::random(7),
        'name' => $faker->name,
        'business' => $faker->company,
        'email' => $faker->email,
        'space_id' => $space->id,
        'user_id' => 1,
        'status_id' => rand(1, 6),
        'phone' => $faker->phoneNumber,
        'price' => $space->getPriceInCents(),
        'tax' => $space->getTaxInCents(),
        'service' => $service,
        'total' => $space->getPriceInCents() + $space->getTaxInCents() + $service,
    ];
});
