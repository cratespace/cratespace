<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedSuccessfully;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderPlacedSuccessfullyEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param \App\Events\OrderPlaced $event
     *
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        Mail::to($event->customer())->queue(
            new OrderPlacedSuccessfully($event->order)
        );
    }
}
