<?php

namespace App\Maintainers;

use App\Models\Order;

class OrdersMaintainer extends Maintainer
{
    /**
     * Run maintenance on resource.
     */
    public function run()
    {
        $this->updateOrderStatus();
    }

    /**
     * Update resource inventory.
     */
    protected function updateOrderStatus()
    {
        $this->getResource()->map(function ($order) {
            $this->makeAvailable($order);
        });
    }

    /**
     * Set status of space associated with order.
     *
     * @param \App\Models\Order $order
     */
    protected function makeAvailable(Order $order)
    {
        if ($order->status === 'Canceled') {
            $order->order->markAs('Available');
        }
    }
}
