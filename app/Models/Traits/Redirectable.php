<?php

namespace App\Models\Traits;

trait Redirectable
{
    /**
     * Get full path to single resource page.
     *
     * @return string
     */
    public function getPathAttribute()
    {
        return route($this->getTable() . '.edit', $this);
    }
}
