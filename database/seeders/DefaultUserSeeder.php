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
        Business::create(array_merge($this->config('business'), [
            'user_id' => User::create($this->config('credentials'))->id,
        ]));
    }

    /**
     * Get default user details.
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function config(string $key)
    {
        return config("defaults.users.{$key}");
    }
}
