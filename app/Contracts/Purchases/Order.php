<?php

namespace App\Contracts\Purchases;

interface Order
{
    /**
     * Determine the status of the order.
     *
     * @return string
     */
    public function status(): string;

    /**
     * Cancel the order.
     *
     * @return void
     */
    public function cancel(): void;
}
