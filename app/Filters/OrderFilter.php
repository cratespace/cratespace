<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends Filter
{
    /**
     * Attributes to filters from.
     *
     * @var array
     */
    protected $filters = ['confirmation_number'];

    /**
     * Filter the query by a given attribute value.
     *
     * @param string $attribute
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function confirmationNumber(string $number): Builder
    {
        return $this->builder->where('confirmation_number', $number);
    }
}
