<?php

namespace App\Mail;

use Illuminate\Support\Facades\URL;

class OrderPlacedSuccessfully extends OrderMail
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.customers.orders.order-placed', [
                'orderUrl' => URL::signedRoute('orders.show', [
                    'order' => $this->order,
                ]),
            ]
        )->subject(__('Cratespace - Order Placed Successfully'));
    }
}
