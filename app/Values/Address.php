<?php

namespace App\Values;

use InvalidArgumentException;

class Address extends Value
{
    /**
     * List of acceptable address values.
     *
     * @var array
     */
    protected static $values = [
        'street',
        'city',
        'state',
        'country',
        'postcode',
    ];

    /**
     * Create new instance of address value object.
     *
     * @param array $address
     */
    public function __construct(array $address)
    {
        $this->address = $address;
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
        if (in_array($value, static::$values)) {
            return $this->address[$value] ?? null;
        }

        throw new InvalidArgumentException("Property [{$value}] does not exist");
    }
}
