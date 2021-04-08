<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Contracts\Billing\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * The instance of the order.
     *
     * @var \App\Contracts\Billing\Order
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @param \App\Contracts\Billing\Order $order
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}