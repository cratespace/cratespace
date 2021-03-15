<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait Directable
{
    /**
     * Get full path to single resource page.
     *
     * @return string
     */
    public function getPathAttribute(): string
    {
        $index = property_exists($this, 'index')
            ? $this->index
            : $this->getIndex();

        return route("{$index}.show", $this);
    }

    /**
     * Get resource index.
     *
     * @return string
     */
    protected function getIndex(): string
    {
        return Str::plural(strtolower(class_basename($this)));
    }
}
