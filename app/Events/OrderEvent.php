<?php

namespace App\Events;

use App\Models\User;
use App\Contracts\Orders\Order;
use App\Contracts\Billing\Payment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class OrderEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Te order instance.
     *
     * @var \App\Contracts\Orders\Order
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param \App\Contracts\Orders\Order
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
        return $this->order->business;
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

    /**
     * Get the payment details that was made.
     *
     * @return \App\Contracts\Billing\Payment
     */
    public function payment(): Payment
    {
        return $this->order->payment;
    }
}
