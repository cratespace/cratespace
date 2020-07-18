<?php

namespace App\Models\Concerns;

trait ManagesStatus
{
    /**
     * Mark resource as given status.
     *
     * @param string $status
     *
     * @return bool
     */
    public function markAs(string $status): bool
    {
        return $this->update(['status' => $status]);
    }

    /**
     * Determine the resource is marked as given status.
     *
     * @param string $status
     *
     * @return bool
     */
    public function markedAs(string $status): bool
    {
        return $this->status === $status;
    }
}
