<?php

namespace App\Models\Values;

class Address extends Value
{
    /**
     * List of acceptable address values.
     *
     * @var array
     */
    protected $values = [
        'street',
        'city',
        'state',
        'country',
        'postcode',
    ];
}
