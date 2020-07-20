<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPendingConfirmation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderDetailsEmail
{
    /**
     * Handle the event.
     *
     * @param  OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        Mail::to($event->getOrder()->email)
            ->cc($event->getOrder()->user->business->email)
            ->send(new OrderPendingConfirmation($event->getOrder()));
    }
}
