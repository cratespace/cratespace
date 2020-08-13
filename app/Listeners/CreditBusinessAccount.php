<?php

namespace App\Listeners;

use App\Models\Order;
use App\Models\Account;
use App\Events\SuccessfullyCharged;

class CreditBusinessAccount
{
    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle(SuccessfullyCharged $event)
    {
        $this->getBusinessAccount($event->order)
            ->increment('credit', $event->order->subtotal);
    }

    /**
     * Get respective business account f order.
     *
     * @param \App\Models\Order $order
     *
     * @return \App\Models\Account
     */
    protected function getBusinessAccount(Order $order): Account
    {
        return Account::where('user_id', $order->user_id)->first();
    }
}
