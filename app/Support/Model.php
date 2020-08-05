<?php

namespace App\Support;

use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model
{
    /**
     * Get name of model in plurals.
     *
     * @param \Illuminate\Database\Eloquent\Model
     *
     * @return string
     */
    public static function getNameInPlural(EloquentModel $instance): string
    {
        return Str::plural(
            strtolower((new ReflectionClass($instance))->getShortName())
        );
    }
}
