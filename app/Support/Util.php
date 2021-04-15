<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Str;
use League\ISO3166\ISO3166;

class Util
{
    /**
     * Get the base class name of the given key string.
     *
     * @param string $key
     *
     * @return string
     */
    public static function className(string $key): string
    {
        return ucfirst(Str::singular($key));
    }

    /**
     * Get Alpha2 reference of given country name.
     *
     * @param string $name
     *
     * @return string
     */
    public static function alpha2(string $name): string
    {
        return (new ISO3166())->name($name)['alpha2'];
    }

    /**
     * Generate unique username from first name.
     *
     * @param string $name
     *
     * @return string
     */
    public static function makeUsername(string $name): string
    {
        $name = trim($name);

        if (User::where('username', 'like', '%' . $name . '%')->count() !== 0) {
            return Str::studly("{$name}-" . Str::random('5'));
        }

        return Str::studly($name);
    }
}
