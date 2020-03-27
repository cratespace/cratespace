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
            $this->expire($order);
        });
    }

    /**
     * Set order status as canceled if associated space has departed.
     *
     * @param  \App\Models\Order  $order
     */
    protected function expire(Order $order)
    {
        if ($order->status !== 'Completed' && $order->space->departed()) {
            $order->markAs('Canceled');

            $order->space->markAs('Expired');
        }
    }
}
