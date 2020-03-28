<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Reports\YearlyReport;
use Illuminate\Support\Collection;

class YearlyReportTest extends TestCase
{
    /** @test */
    public function it_gives_an_array_of_data_counts_per_month()
    {
        $user = $this->signIn();

        for ($i = 0; $i < 13; $i++) {
            create(Space::class, [
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subMonths(rand(0, 50))
            ]);
        }

        $graph = new YearlyReport(new Space);
        $graph->collectDataof($user->id);
        $graphData = $graph->make();

        $this->assertInstanceOf(Collection::class, $graphData);

        $months = array_keys($graphData->toArray());

        for ($i = 0; $i <= 11; $i++) {
            $this->assertEquals($i + 1, $months[$i]);
        }

        foreach ($graphData as $key => $value) {
            $this->assertTrue(is_int($value));
        }
    }
}