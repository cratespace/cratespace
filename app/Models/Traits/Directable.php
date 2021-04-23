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
        return route("{$this->getIndex()}.show", $this);
    }

    /**
     * Get resource index.
     *
     * @return string
     */
    protected function getIndex(): string
    {
        if (property_exists($this, 'index')) {
            return $this->index;
        }

        return Str::plural(strtolower(class_basename($this)));
    }
}
