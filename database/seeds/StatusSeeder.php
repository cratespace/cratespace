<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('defaults.statuses') as $title => $label) {
            Status::create([
                'title' => $title,
                'label' => $label,
            ]);
        }
    }
}
