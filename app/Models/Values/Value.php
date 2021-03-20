<?php

namespace App\Models\Values;

use InvalidArgumentException;

abstract class Value
{
    /**
     * List of acceptable values.
     *
     * @var array
     */
    protected $values = [];

    /**
     * Details to be recorded by this value.
     *
     * @var array
     */
    protected $details;

    /**
     * Create new instance of value object.
     *
     * @param array $details
     */
    public function __construct(array $details)
    {
        $this->details = $details;
    }

    /**
     * Dynamically get address property.
     *
     * @param string $value
     *
     * @return mixed
     */
    public function __get(string $value)
    {
        if (property_exists($this, 'values') && in_array($value, $this->values)) {
            return $this->details[$value];
        }

        if (isset($this->details[$value])) {
            return $this->details[$value];
        }

        throw new InvalidArgumentException("Property [{$value}] does not exist");
    }
}
