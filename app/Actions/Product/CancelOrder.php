<?php

namespace App\Actions\Product;

use App\Contracts\Billing\Order;

class CancelOrder
{
    /**
     * Cancel the given order.
     *
     * @param \App\Contracts\Billing\Order $order
     *
     * @return void
     */
    public function cancel(Order $order): void
    {
    }
}
