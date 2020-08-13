<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced as OrderPlacedMail;
use App\Events\OrderPlaced as OrderPlacedEvent;

class SendOrderPlacedNotification
{
    /**
     * Handle the event.
     *
     * @param \App\Events\OrderPlaced $event
     *
     * @return void
     */
    public function handle(OrderPlacedEvent $event)
    {
        Mail::to($event->order->email)
            ->send(new OrderPlacedMail($event->order));
    }
}
