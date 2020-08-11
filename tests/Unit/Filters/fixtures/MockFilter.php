<?php

namespace Tests\Unit\Filters\fixtures;

use App\Filters\Filter;

class MockFilter extends Filter
{
    /**
     * Attributes to filters from.
     *
     * @var array
     */
    protected $filters = ['foo'];

    /**
     * Filter by bar.
     *
     * @return string
     */
    public function foo()
    {
        return 'bar';
    }
}
