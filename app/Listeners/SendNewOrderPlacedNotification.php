<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\NewOrderPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewOrderPlacedNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPlaced  $event
     */
    public function handle(OrderPlaced $event)
    {
        $event->getOrder()->user->notify(
            new NewOrderPlaced($event->getOrder())
        );
    }
}
