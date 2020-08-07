<?php

namespace Tests\Unit\Reports;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Reports\WeeklyReport;
use App\Reports\Query\Builder;

class WeeklyReportTest extends TestCase
{
    /** @test */
    public function it_gives_an_array_of_data_counts_per_week()
    {
        $user = $this->signIn();
        $query = new Builder('spaces');
        $query->setForAuthurizedOnly();

        $endOfWeek = Carbon::now()->ENDOfWeek(Carbon::SUNDAY)->day;

        for ($i = 0; $i < $endOfWeek; ++$i) {
            create(Space::class, [
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subDays($i),
            ], rand(1, 10));
        }

        $graph = new WeeklyReport($query);
        $graphData = $graph->make();

        $this->assertTrue(array_key_exists(Carbon::now()->toDateString(), $graphData->toArray()));
        // $this->assertCount(Carbon::now()->startOfWeek(Carbon::MONDAY)->day + 1, $graphData);
        $this->assertInstanceOf(Carbon::class, Carbon::parse(collect($graphData)->keys()->first()));
    }
}
