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
                'created_at' => Carbon::now()->subHours($i),
            ]);
        }

        $generator = new ReportGenerator('spaces', true);
        $generator->setOptions([
            'report' => DailyReport::class,
            'limit' => null,
        ]);
        $graph = $generator->generate();

        $this->assertCount(24, $graph);
        $this->assertInstanceOf(
            Carbon::class,
            Carbon::parse(collect($graph)->keys()->first())
        );
    }
}
