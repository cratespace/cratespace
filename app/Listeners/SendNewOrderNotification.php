<?php

namespace App\Listeners;

use App\Events\SuccessfullyChargedEvent;

class SendNewOrderNotification
{
    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle(SuccessfullyChargedEvent $event)
    {
    }
}
