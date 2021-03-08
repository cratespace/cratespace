<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Business;
use Illuminate\Database\Seeder;

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

        Business::create(['name' => 'Example, Inc.', 'user_id' => $user->id]);
    }
}
