<?php

namespace App\Auth\Config;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class Auth
{
    /**
     * Get all Auth speciific configurations.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function config(string $key, $default = null)
    {
        if ($value = Config::get("auth.defaults.{$key}")) {
            return $value;
        }

        return Config::get("auth.{$key}", $default);
    }

    /**
     * Get specified sentinel configuration dynamically.
     *
     * @param string $name
     * @param mixed  $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $name, $arguments)
    {
        return static::config(Str::snake($name), ...$arguments);
    }
}
