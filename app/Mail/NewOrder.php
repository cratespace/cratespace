<?php

namespace App\Mail;

use App\Mail\Traits\SenderDetails;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrder extends Mailable
{
    use Queueable;
    use SerializesModels;
    use SenderDetails;

    /**
     * The new order that was placedand is to be notified about.
     *
     * @var \App\Models\Order
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
            ->to(
                $this->order->user->business->email,
                $this->order->user->business->name
            )
            ->subject('New Order Placed')
            ->markdown(
                'components.emails.businesses.new-order',
                ['order' => $this->order]
            );
    }
}
