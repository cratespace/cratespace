<?php

namespace Tests\Unit\Reports;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Reports\Report;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportTest extends TestCase
{
    /** @test */
    public function it_can_make_a_collection_out_of_a_query()
    {
        $user = $this->signIn();
        for ($i = 0; $i < date('t') + 1; ++$i) {
            create(Space::class, [
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subDays(rand(0, 50)),
            ]);
        }

        $query = DB::table('spaces')
            ->select('id', 'created_at')
            ->where('user_id', $user->id);

        $report = new MockReport($query);

        $this->assertInstanceOf(Collection::class, $report->collection());
    }
}

class MockReport extends Report
{
}
