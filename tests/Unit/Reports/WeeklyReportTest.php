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

        for ($i = 0; $i < 8; ++$i) {
            create(Space::class, [
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subDays($i),
            ], rand(1, 10));
        }

        $graph = new WeeklyReport($query);
        $graphData = $graph->make();

        $this->assertCount(
            Carbon::now()->subDay()->startOfWeek(Carbon::MONDAY)->day,
            $graphData
        );
        $this->assertInstanceOf(
            Carbon::class,
            Carbon::parse(collect($graphData)->keys()->first())
        );
    }
}
