<?php

namespace App\Analytics;

class SpacesAnalyzer extends Analyzer
{
    /**
     * Status categoreis specific to resource.
     *
     * @var array
     */
    protected $statusList = [
        'available' => 'Available',
        'ordered' => 'Ordered',
        'completed' => 'Completed',
        'expired' => 'Expired'
    ];
}
