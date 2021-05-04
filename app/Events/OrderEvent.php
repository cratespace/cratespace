<?php

namespace App\Events;

use App\Models\Order;
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
     * @var \App\Models\Order
     */
    protected $order;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Order
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
