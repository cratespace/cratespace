<?php

namespace Tests\Unit\Filters;

use Tests\TestCase;
use Illuminate\Http\Request;
use Tests\Fixtures\MockFilter;

class FilterTest extends TestCase
{
    public function testCanGetRelevantFiltersFromTheHttpReqeustInstance()
    {
        $mockFilter = new MockFilter(Request::create('/?foo=1', 'GET'));

        $this->assertEquals(['foo' => 1], $mockFilter->getFilters());
    }
}
