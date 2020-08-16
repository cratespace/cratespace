<?php

namespace App\Listeners;

use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;
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
        Mail::to($event->order->email)
            ->send(new OrderStatusUpdatedMail($event->order));
    }
}
