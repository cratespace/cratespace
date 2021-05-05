<?php

namespace App\Filters;

use Cratespace\Preflight\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SpaceFilter extends Filter
{
    /**
     * Attributes to filters from.
     *
     * @var array
     */
    protected $filters = ['filter'];

    /**
     * Filter the query by a given attribute value.
     *
     * @param string $attribute
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function filter(string $attribute): Builder
    {
        return $this->builder->whereAttribute($attribute);
    }
}
