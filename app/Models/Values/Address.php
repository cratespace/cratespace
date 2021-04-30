<?php

namespace App\Models\Values;

use Cratespace\Preflight\Models\Values\Value;

class Address extends Value
{
    /**
     * List of acceptable address values.
     *
     * @var array
     */
    protected $values = [
        'line1',
        'line2',
        'city',
        'state',
        'country',
        'postal_code',
    ];
}
