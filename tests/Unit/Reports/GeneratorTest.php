<?php

namespace Tests\Unit\Reports;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Reports\DailyReport;
use App\Reports\Generator as ReportGenerator;

class GeneratorTest extends TestCase
{
    /** @test */
    public function it_can_generate_given_reports()
    {
        $user = $this->signIn();

        for ($i = 0; $i < 24; ++$i) {
            create(Space::class, [
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subHours(rand(0, 24)),
            ]);
        }

        $graph = new ReportGenerator('spaces', true);
        $graphData = $graph->generate(DailyReport::class);

        foreach ($graphData as $time => $count) {
            $this->assertEquals(
                Space::whereTime('created_at', '=', Carbon::parse($time))->count(),
                $count
            );
        }
    }
}
