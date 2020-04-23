<?php

namespace App\Models\Traits;

trait HasStatus
{
    /**
     * Determine if the shipment is due and has left.
     *
     * @return bool
     */
    public function departed()
    {
        return $this->departs_at <= now() || $this->status === 'Expired';
    }

    /**
     * Determine if the shipment has been ordered.
     *
     * @return bool
     */
    public function ordered()
    {
        return $this->order()->exists() || $this->status === 'Ordered';
    }

    /**
     * Mark the space as expired.
     *
     * @param mixed $status
     */
    public function markAs($status)
    {
        $this->update(['status' => $status]);
    }
}
