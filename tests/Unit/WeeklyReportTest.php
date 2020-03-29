<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Reports\WeeklyReport;
use Illuminate\Support\Collection;

class WeeklyReportTest extends TestCase
{
    /** @test */
    public function it_gives_an_array_of_data_counts_per_week()
    {
        $user = $this->signIn();

        for ($i = 0; $i < 8; $i++) {
            create(Space::class, [
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subDays($i)
            ]);
        }

        $graph = new WeeklyReport(new Space);
        $graph->collectDataof($user->id);
        $graphData = $graph->make();

        $this->assertInstanceOf(Collection::class, $graphData);

        $days = array_keys($graphData->toArray());

        $this->assertEquals(
            [
              0 => "Sun",
              1 => "Mon",
              2 => "Tue",
              3 => "Wed",
              4 => "Thu",
              5 => "Fri",
              6 => "Sat",
            ],
            $days
        );

        foreach ($graphData as $key => $value) {
            $this->assertTrue(is_int($value));
        }
    }
}
