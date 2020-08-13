<?php

namespace App\Listeners;

use App\Models\Account;

class CreditBusinessAccount
{
    public $order;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle($event)
    {
        $this->getBusinessAccount($order)
            ->increment('credit', $order->subtotal);
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
        return Account::where('user_id', $event->order->user_id)->first();
    }
}
