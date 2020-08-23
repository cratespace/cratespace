<?php

namespace App\Models\Concerns;

use RuntimeException;

trait ManagesStatus
{
    /**
     * Mark resource with given status.
     *
     * @param string $status
     *
     * @return bool
     */
    public function mark(string $status): bool
    {
        if (array_key_exists('status', $this->getAttributes())) {
            return in_array($status, $this->getDefaultStatuses())
                ? $this->update(['status' => $status])
                : false;
        }

        throw new RuntimeException("Model does not have 'status' attribute");
    }

    /**
     * Determine if the resource is marked by given status.
     *
     * @param string $status
     *
     * @return bool
     */
    public function marked(string $status): bool
    {
        return $this->status === $status;
    }

    /**
     * Get array of default statuses.
     *
     * @return array
     */
    public function getDefaultStatuses(): array
    {
        return config("defaults.{$this->getTable()}.statuses");
    }
}
