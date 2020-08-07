<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAbilitiesSeeder::class);
        $this->call(DefaultUserSeeder::class);
        $this->call(DummyDataSeeder::class);
    }
}
