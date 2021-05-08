<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\NewOrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewOrderPlacedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param \App\Notifications\NewOrderPlaced $event
     *
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        $event->business()->notify(
            new NewOrderPlaced($event->order)
        );

        $event->customer()->notify(
            new NewOrderPlaced($event->order, true)
        );
    }
}
