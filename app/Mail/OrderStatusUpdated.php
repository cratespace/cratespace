<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Mail\Traits\SenderDetails;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels, SenderDetails;

    /**
     * The order details.
     *
     * @var array
     */
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(...$this->getSenderDetails())
            ->to($this->order->email, $this->order->name)
            ->subject('Order ' . $this->order->status)
            ->markdown(
                'emails.customers.order-status',
                ['order' => $this->order]
            );
    }
}
