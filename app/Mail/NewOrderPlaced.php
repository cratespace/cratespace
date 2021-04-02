<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Contracts\Billing\Order;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;

class NewOrderPlaced extends Mailable
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

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.businesses.orders.new-order', [
                'orderUrl' => URL::signedRoute('order.show', [
                    'order' => $this->order,
                ]),
            ]
        )->subject(__('Cratespace - New Order Placed'));
    }
}
