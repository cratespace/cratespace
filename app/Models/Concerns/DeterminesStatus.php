<?php

namespace App\Models\Concerns;

use Carbon\Carbon;

trait DeterminesStatus
{
    /**
     * Determine if the product has expired.
     *
     * @return bool
     */
    public function expired(): bool
    {
        return $this->departs_at->isBefore(Carbon::now());
    }

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
