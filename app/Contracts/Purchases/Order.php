<?php

namespace App\Contracts\Purchases;

use App\Contracts\Billing\Payment;

interface Order extends Payment
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
