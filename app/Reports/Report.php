<?php

namespace App\Reports;

use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;

abstract class Report
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function collection(): Collection
    {
        return $this->query->get();
    }
}
