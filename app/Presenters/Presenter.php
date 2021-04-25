<?php

namespace App\Presenters;

use App\Support\Eloquent;
use InvalidArgumentException;

class Presenter extends Eloquent
{
    /**
     * Show method as property if property does not exist.
     *
     * @param string $property
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        throw new InvalidArgumentException(sprintf('%s does not respond to the property or method "%s"', static::class, $property));
    }
}
