<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'code' => strtoupper(Str::random(12)),
        'subject' => $faker->sentence,
        'status' => 'Open',
        'priority' => $faker->randomElement(['Low', 'Medium', 'High']),
        'message' => $faker->paragraph(7),
        'attachment' => null,
        'user_id' => create(User::class)->id,
        'agent_id' => null,
    ];
});
