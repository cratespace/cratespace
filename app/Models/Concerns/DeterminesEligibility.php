<?php

namespace App\Models\Concerns;

trait DeterminesEligibility
{
    /**
     * Determine if the order is eligible for cancellation.
     *
     * @return bool
     */
    public function eligibleForCancellation(): bool
    {
        return ! $this->product()->expired() &&
            ! $this->product()->schedule->nearingDeparture();
    }
}
