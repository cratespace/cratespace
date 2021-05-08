<?php

namespace App\Events;

use App\Models\User;
use App\Contracts\Billing\Payment;

class PurchaseSuccessful extends PurchaseEvent
{
    /**
     * Get the business the payment was made for.
     *
     * @return \App\Models\User
     */
    public function business(): User
    {
        return $this->order->business;
    }

    /**
     * Get the payment details that was made.
     *
     * @return \App\Contracts\Billing\Payment
     */
    public function payment(): Payment
    {
        return $this->order->payment;
    }
}
