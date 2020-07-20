<?php

namespace App\Models\Traits;

use ReflectionClass;
use Illuminate\Support\Str;

trait GetsPathToResource
{
    /**
     * Get full path to resource page.
     *
     * @return string
     */
    public function getPathAttribute()
    {
        return $this->path();
    }

    /**
     * Get full path to resource page.
     *
     * @return string
     */
    public function path(string $action = 'show'): string
    {
        return route("{$this->getResourceName()}.{$action}", $this);
    }

    /**
     * Determine the activity type.
     *
     * @return string
     */
    protected function getResourceName()
    {
        return Str::plural(strtolower((new ReflectionClass($this))->getShortName()));
    }
}
