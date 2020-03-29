<?php

namespace App\Listeners;

use App\Events\PaymentProcessingSucceeded;

class UpdateBusinessCredit
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\PaymentProcessingSucceeded  $event
     * @return void
     */
    public function handle(PaymentProcessingSucceeded $event)
    {
        $event->user->account()->update([
            'credit' => $event->credit
        ]);
    }
}
