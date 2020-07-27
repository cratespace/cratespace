<?php

namespace Tests\Unit\Reports;

use Carbon\Carbon;
use Tests\TestCase;
use ReflectionClass;
use App\Reports\Report;
use App\Reports\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

class ReportTest extends TestCase
{
    /** @test */
    public function it_can_build_make_an_instance_of_query_builder()
    {
        $user = $this->signIn();

        $query = new Builder('spaces');
        $query->setForAuthurizedOnly();
        $report = new MockDailyReport($query);

        $reportReflection = new ReflectionClass($report);
        $getReportProperty = $reportReflection->getProperty('query');
        $getReportProperty->setAccessible(true);

        $this->assertInstanceOf(QueryBuilder::class, $getReportProperty->getValue($report));
    }

    /** @test */
    public function it_can_make_a_collection_out_of_a_query()
    {
        $user = $this->signIn();

        $query = new Builder('spaces');
        $query->setForAuthurizedOnly();
        $report = new MockDailyReport($query);

        $this->assertInstanceOf(Collection::class, $report->collection());
    }

    /** @test */
    public function it_can_build_reports()
    {
        $user = $this->signIn();

        $query = new Builder('spaces');
        $query->setForAuthurizedOnly();
        $report = new MockDailyReport($query);
        $graph = new MockDailyReport($query);

        $this->assertInstanceOf(Collection::class, $graph->build());
    }
}

class MockDailyReport extends Report
{
    protected $key = 'time';

    public function getTimeframe(): array
    {
        return [
            Carbon::now()->startOfDay()->toTimeString(),
            Carbon::now()->endOfDay()->toTimeString(),
        ];
    }
}
