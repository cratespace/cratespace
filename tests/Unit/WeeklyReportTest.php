<?php

namespace Tests\Unit;

use App\Models\Space;
use App\Reports\WeeklyReport;
use Carbon\Carbon;
use Tests\TestCase;

class WeeklyReportTest extends TestCase
{
    /** @test */
    public function it_gives_an_array_of_data_counts_per_week()
    {
        $user = $this->signIn();

        for ($i = 0; $i < 8; ++$i) {
            create(Space::class, [
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subDays($i),
            ]);
        }

        $space = Space::whereUserId($user->id);
        $graph = new WeeklyReport($space);
        $graphData = $graph->make();

        $days = array_keys($graphData->toArray());

        foreach ($graphData as $key => $value) {
            $this->assertTrue(is_string($key));
            $this->assertTrue(is_int($value));
        }
    }
}
