<?php

namespace App\Models\Values;

use Cratespace\Preflight\Models\Values\Value;

class Dimensions extends Value
{
    /**
     * List of acceptable address values.
     *
     * @var array
     */
    protected $values = [
        'height',
        'width',
        'length',
    ];
}
