<?php

namespace App\Listeners;

use App\Mail\OrderPlacedMail;
use App\Events\OrderPlacedEvent;
use Illuminate\Support\Facades\Mail;

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
        Mail::to($event->order->email)->send(new OrderPlacedMail($event->order));
    }
}
