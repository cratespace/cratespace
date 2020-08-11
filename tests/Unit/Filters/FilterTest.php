<?php

namespace Tests\Unit\Filters;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Filters\fixtures\MockFilter;

class FilterTest extends TestCase
{
    /** @test */
    public function it_can_get_relevant_filters_from_the_http_reqeust_instance()
    {
        $mockFilter = new MockFilter(Request::create('/?foo=1', 'GET'));

        $this->assertEquals(['foo' => 1], $mockFilter->getFilters());
    }
}
