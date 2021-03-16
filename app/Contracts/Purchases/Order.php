<?php

namespace App\Contracts\Purchases;

use App\Contracts\Billing\Payment;

interface Order extends Payment
{
    /**
     * Cancel the order.
     *
     * @return void
     */
    public function cancel(): void;
}
