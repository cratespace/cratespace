<?php

namespace Tests\Unit\Reports;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Reports\DailyReport;
use Illuminate\Support\Facades\DB;

class DailyReportTest extends TestCase
{
    /** @test */
    public function it_gives_an_array_of_data_counts_per_day()
    {
        $user = $this->signIn();

        for ($i = 0; $i < 24; ++$i) {
            create(Space::class, [
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subHours(rand(0, 24)),
            ]);
        }

        $query = DB::table('spaces')
            ->select('id', 'created_at')
            ->where('user_id', $user->id);

        $graph = new DailyReport($query);
        $graphData = $graph->make();

        foreach ($graphData as $time => $count) {
            $this->assertEquals(
                Space::whereTime('created_at', '=', Carbon::parse($time))->count(),
                $count
            );
        }
    }
}
