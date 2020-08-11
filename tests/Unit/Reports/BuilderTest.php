<?php

namespace Tests\Unit\Reports;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use App\Reports\Query\Builder as ReportBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class BuilderTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $builder = new ReportBuilder('mock');

        $this->assertInstanceOf(ReportBuilder::class, $builder);
    }

    /** @test */
    public function it_can_build_an_instance_of_query_builder()
    {
        $builder = new ReportBuilder('mock');

        $this->assertInstanceOf(QueryBuilder::class, $this->setAccessibleMethod($builder, 'getFacade', []));
    }

    /** @test */
    public function it_can_build_a_query_for_autherized_user()
    {
        $builderSeconda = new ReportBuilder('mock');
        $this->assertFalse(in_array('user_id', Arr::flatten($builderSeconda->build()->wheres)));

        $this->signIn();

        $builderFirst = new ReportBuilder('mock');
        $builderFirst->setForAuthurizedOnly();
        $this->assertTrue(in_array('user_id', Arr::flatten($builderFirst->build()->wheres)));
    }
}

class MockModel extends Model
{
    protected $table = 'mock';
}
