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
        return $this->from('people@cratesapce.biz')
            ->markdown(
                'emails.businesses.orders.new-order', [
                    'orderUrl' => URL::signedRoute('spaces.show', [
                        'space' => $this->order->orderable,
                    ]),
                ]
            )->subject(__('Cratespace - New Order Placed'));
    }
}
