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
     * @param array|null $details
     */
    public function __construct(?array $details = null)
    {
        $this->details = $details;
    }

    /**
     * Dynamically get address property.
     *
     * @param string $value
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __get(string $value)
    {
        if (! empty($this->values)) {
            return $this->getWithConstraints($value);
        }

        if (isset($this->details[$value])) {
            return $this->details[$value];
        }

        $this->throwPropertyDoesNotExist($value);
    }

    /**
     * Get value of key included within $values property.
     *
     * @param string $value
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function getWithConstraints(string $value)
    {
        if (in_array($value, $this->values)) {
            return $this->details[$value];
        }

        $this->throwPropertyDoesNotExist($value);
    }

    /**
     * Throw property does not exist exception.
     *
     * @param string $property
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function throwPropertyDoesNotExist(string $property): void
    {
        throw new InvalidArgumentException("Property [{$property}] does not exist");
    }
}
