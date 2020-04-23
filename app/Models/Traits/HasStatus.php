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
<<<<<<< HEAD
        return $this->departs_at <= now() || $this->status === 'Expired';
=======
        return $this->departs_at <= now() || 'Expired' === $this->status;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
    }

    /**
     * Determine if the shipment has been ordered.
     *
     * @return bool
     */
    public function ordered()
    {
<<<<<<< HEAD
        return $this->order()->exists() || $this->status === 'Ordered';
=======
        return $this->order()->exists() || 'Ordered' === $this->status;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
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
