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
        create(Space::class, ['user_id' => 1], 20)->each(function ($space) {
            $service = $space->getPriceInCents() * config('charges.service');

            for ($i = 0; $i < 8; ++$i) {
                create(Order::class, [
                    'user_id' => 1,
                    'space_id' => $space->id,
                    'price' => $space->getPriceInCents(),
                    'tax' => $space->getTaxInCents(),
                    'service' => $service,
                    'total' => $space->getPriceInCents() + $space->getTaxInCents() + $service,
                    'created_at' => Carbon::now()->subDays($i),
                ], rand(1, 12));
            }
        });
    }
}
