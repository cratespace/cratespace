<?php

namespace App\Listeners;

use App\Events\PaymentSuccessful;

class MakePayout
{
    /**
     * Handle the event.
     *
     * @param \App\Events\PaymentSuccessful $event
     *
     * @return void
     */
    public function handle(PaymentSuccessful $event)
    {
        $event->business()->makePayout($event->payment);
    }
}
