<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Business;
use Faker\Generator as Faker;

$factory->define(Business::class, function (Faker $faker) {
    $name = $faker->unique()->company;

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        // 'logo' => $faker->image('public/storage/images/company.png', 400, 400),
        'description' => $faker->sentence(7),
        'street' => $faker->streetName,
        'city' => $faker->city,
        'state' => $faker->state,
        'country' => $faker->country,
        'postcode' => $faker->postcode,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'user_id' => null,
    ];
});
