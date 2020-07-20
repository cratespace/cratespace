<?php

namespace Tests\Unit\Reports;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Reports\DailyReport;

class DailyReportTest extends TestCase
{
    /** @test */
    public function it_gives_an_array_of_data_counts_per_day()
    {
        $user = $this->signIn();

        for ($i = 0; $i < date('t') + 1; ++$i) {
            create(Space::class, [
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subDays(rand(0, 50)),
            ]);
        }

        $space = Space::whereUserId($user->id);
        $graph = new DailyReport($space);
        $graphData = $graph->make(date('t'));

        $days = array_keys($graphData->toArray());

        for ($i = 0; $i <= date('t') - 1; ++$i) {
            $this->assertEquals($i + 1, $days[$i]);
        }

        foreach ($graphData as $key => $value) {
            $this->assertTrue(is_int($value));
        }
    }
}
