<?php

namespace App\Contracts\Billing;

interface Payment
{
    /**
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount(): string;

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount(): int;

    /**
     * Determine the status of the order.
     *
     * @return string
     */
    public function status(): string;
}
