<?php

namespace App\Observers;

use App\Models\Order;
use App\Events\OrderStatusUpdatedEvent;

class OrderObserver
{
    /**
     * All order statuses to notify the customer about.
     *
     * @var array
     */
    protected $mailableStatus = [
        'Approved',
        'Shipped',
        'Delivered',
    ];

    /**
     * Handle the order "updated" event.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    public function updated(Order $order)
    {
        if (in_array($order->status, $this->mailableStatus)) {
            event(new OrderStatusUpdatedEvent($order));
        }
    }
}
