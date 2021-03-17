<?php

namespace App\Contracts\Support;

interface Statusable
{
    /**
     * Determine if the entity is "available".
     *
     * @return bool
     */
    public function available(): bool;

    /**
     * Determine if the entity is "pending".
     *
     * @return bool
     */
    public function pending(): bool;

    /**
     * Determine if the entity is "expired".
     *
     * @return bool
     */
    public function expired(): bool;

    /**
     * Determine if the entity is "canceled".
     *
     * @return bool
     */
    public function canceled(): bool;

    /**
     * Determine if the entity is "completed".
     *
     * @return bool
     */
    public function completed(): bool;
}
