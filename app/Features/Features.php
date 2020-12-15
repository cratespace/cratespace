<?php

namespace App\Features;

use Illuminate\Support\Str;
use InvalidArgumentException;

abstract class Features
{
    /**
     * Determine if the given feature is enabled.
     *
     * @param string $feature
     *
     * @return bool
     */
    public static function enabled(string $feature): bool
    {
        return in_array($feature, config('features.' . static::$prefix));
    }

    /**
     * Dynamically check for enabled features.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return bool
     */
    public static function __callStatic($name, $arguments)
    {
        if (!Str::contains($name, 'has')) {
            throw new InvalidArgumentException("Method [{$name}] does not exist.");
        }

        if (!method_exists(new static(), $name = Str::camel(substr($name, 3)))) {
            throw new InvalidArgumentException("Feature [{$name}] does not exist.");
        }

        return static::enabled(call_user_func_array([new static(), $name], $arguments));
    }
}
