<?php

namespace App\Models\Values;

use Cratespace\Preflight\Models\Values\Value;

class Settings extends Value
{
    /**
     * List of acceptable values.
     *
     * @var array
     */
    protected $values = [
        'notifications'
    ];
}
