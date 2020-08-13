<?php

namespace App\Listeners;

use App\Events\SuccessfullyCharged;

class SendNewOrderNotification
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
    }
}
