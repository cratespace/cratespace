<?php

namespace App\Models\Concerns;

use Carbon\Carbon;

trait DetectsStatus
{
    /**
     * Determine if the space is associated with an order.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        if (!$this->isExpired()) {
            return !$this->hasOrder();
        }

        return false;
    }

    /**
     * Determine if the space departure date is close or has passed.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->departs_at <= Carbon::now();
    }

    /**
     * Determine if the space is associated with an order.
     *
     * @return bool
     */
    public function hasOrder(): bool
    {
        if (is_null($this->reserved_at)) {
            return false;
        }

        return true;
    }
}
