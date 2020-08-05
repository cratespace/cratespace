<?php

namespace App\Models\Concerns;

use App\Support\Model as ModelHelpers;

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
        $resourceName = ModelHelpers::getNameInPlural($this);

        return route("{$resourceName}.{$action}", $this);
    }
}
