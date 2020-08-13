<?php

namespace App\Listeners;

use App\Mail\OrderStatusUpdated as OrderStatusUpdatedMail;
use App\Events\OrderStatusUpdated as OrderStatusUpdatedEvent;

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
        Mail::to($event->order->email)
            ->send(new OrderStatusUpdatedMail($event->order));
    }
}
