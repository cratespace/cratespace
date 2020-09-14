<?php

namespace App\Listeners;

use App\Mail\OrderPlacedMail;
use App\Events\OrderPlacedEvent;

class SendOrderPlacedNotification
{
    /**
     * Handle the event.
     *
     * @param \App\Events\OrderPlacedEvent $event
     *
     * @return void
     */
    public function handle(OrderPlacedEvent $event)
    {
        $event->order->mail(OrderPlacedMail::class);
    }
}
