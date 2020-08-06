<?php

use Carbon\Carbon;
use App\Models\Order;
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
        create(Space::class, ['user_id' => 1], 7)->each(function ($space) {
            $service = $space->fullPrice() * config('charges.service');

            create(Order::class, [
                'user_id' => 1,
                'space_id' => $space->id,
                'price' => $space->price(),
                'tax' => $space->tax(),
                'service' => $service,
                'total' => $space->price() + $space->tax() + $service,
                'created_at' => Carbon::now()->subDays(rand(1, 10)),
            ]);
        });
    }
}
