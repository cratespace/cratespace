<?php

namespace App\Contracts\Models;

interface Statusable
{
    /**
     * Determine if the resource is available to perform an action on.
     *
     * @return bool
     */
    public function isAvailable(): bool;
}
