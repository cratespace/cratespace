<?php

namespace App\Models\Concerns;

trait DeterminesStatus
{
    /**
     * Determine if the space is reserved.
     *
     * @return bool
     */
    public function reserved(): bool
    {
        return ! is_null($this->reserved_at) || $this->order()->exists();
    }
}
