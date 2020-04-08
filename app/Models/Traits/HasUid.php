<?php

namespace App\Models\Traits;

trait HasUid
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }
}
