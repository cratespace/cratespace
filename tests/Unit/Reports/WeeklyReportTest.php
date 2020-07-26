<?php

namespace Tests\Unit\Reports;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Reports\WeeklyReport;
use Illuminate\Support\Facades\DB;

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
            ], rand(1, 12));
        }

        $query = DB::table('spaces')
            ->select('id', 'created_at')
            ->where('user_id', $user->id);

        $graph = new WeeklyReport($query);
        $graphData = $graph->make();

        foreach ($graphData as $date => $count) {
            $this->assertEquals(
                Space::whereDate('created_at', '=', Carbon::parse($date))->count(),
                $count
            );
        }
    }
}
