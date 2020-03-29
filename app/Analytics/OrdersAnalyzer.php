<?php

namespace App\Analytics;

class OrdersAnalyzer extends Analyzer
{
    /**
     * Status categoreis specific to resource.
     *
     * @var array
     */
    protected $statusList = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'completed' => 'Completed',
        'canceled' => 'Canceled'
    ];
}
