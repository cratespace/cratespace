<?php

namespace App\Listeners;

use App\Events\PaymentSuccessful;
use App\Contracts\Actions\CalculatesAmount;

class MakePayout
{
    /**
     * Create new listener instance.
     *
     * @param \App\Contracts\Actions\CalculatesAmount $payout
     */
    public function __construct(CalculatesAmount $payout)
    {
        $this->payout = $payout;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\PaymentSuccessful $event
     *
     * @return void
     */
    public function handle(PaymentSuccessful $event)
    {
        $event->business()->addCredit(
            $this->payout->calculate($event->charge->rawAmount())
        );
    }
}
