<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPendingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

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
            ->subject('Order Pending Confirmation')
            ->view('emails.customers.order-pending');
    }

    /**
     * Get details regarding email sender.
     *
     * @return array
     */
    protected function getSenderDetails()
    {
        return [
            config('emailaddresses.orders.address'),
            config('emailaddresses.orders.name')
        ];
    }
}
