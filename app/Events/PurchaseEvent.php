<?php

namespace App\Events;

use App\Contracts\Orders\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PurchaseEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    protected $order;

    /**
     * Create a new event instance.
     *
     * @param \App\Contracts\Orders\Order $order
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
