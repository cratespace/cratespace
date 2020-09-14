<?php

namespace App\Listeners;

use App\Mail\OrderStatusUpdatedMail;
use App\Events\OrderStatusUpdatedEvent;

class SendOrderStatusUpdatedNotification
{
    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle(OrderStatusUpdatedEvent $event)
    {
        $event->order->mail(OrderStatusUpdatedMail::class);
    }
}
