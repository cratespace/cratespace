<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use App\Models\User;
use App\Models\Reply;
use App\Models\Ticket;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    $agent = create(User::class);
    $agent->assignRole(Role::create(['title' => 'support-agent']));

    return [
        'body' => $faker->paragraph(7),
        'ticket_id' => create(Ticket::class)->id,
        'user_id' => create(User::class)->id,
        'agent_id' => $agent->id,
    ];
});
