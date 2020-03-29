<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use App\Models\Profile;
use App\Models\Category;
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
        create(Space::class, ['user_id' => 1]);
    }
}
