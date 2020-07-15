<?php

use App\Models\Space;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        create(Space::class, ['user_id' => 1], 20);
    }
}
