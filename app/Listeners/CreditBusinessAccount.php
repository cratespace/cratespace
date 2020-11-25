<?php

namespace App\Listeners;

use App\Models\Account;
use App\Events\SuccessfullyChargedEvent;

class CreditBusinessAccount
{
    /**
     * Handle the event.
     *
     * @param \App\Events\SuccessfullyChargedEvent $event
     *
     * @return void
     */
    public function handle(SuccessfullyChargedEvent $event)
    {
        Account::where('user_id', $event->order->user_id)
            ->first()
            ->increment(
                'credit',
                $event->order->subtotal
            );
    }
}
