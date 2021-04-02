<?php

namespace App\Events;

use App\Models\User;
use App\Contracts\Billing\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class OrderEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Models\Order
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param \App\Contracts\Purchases\Order $order
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the business the order was placed for.
     *
     * @return \App\Models\User
     */
    public function business(): User
    {
        return $this->order->user;
    }

    /**
     * Get the customer the order was placed by.
     *
     * @return \App\Models\User
     */
    public function customer(): User
    {
        return $this->order->customer;
    }
}
