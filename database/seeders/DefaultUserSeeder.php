<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Cratespace\Preflight\Models\Role;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(config('defaults.users.credentials'));

        $user->assignRole(Role::firstOrCreate([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]));

        $user->business()->create(config('defaults.users.business'));

        $user->customer()->create(config('defaults.users.customer'));
    }
}
