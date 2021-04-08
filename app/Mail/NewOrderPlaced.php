<?php

namespace App\Mail;

use Illuminate\Support\Facades\URL;

class NewOrderPlaced extends OrderMail
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.businesses.orders.new-order', [
                'orderUrl' => URL::signedRoute('orders.show', [
                    'order' => $this->order,
                ]),
            ]
        )->subject(__('Cratespace - New Order Placed'));
    }
}
