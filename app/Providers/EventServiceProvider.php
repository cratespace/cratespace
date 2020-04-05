<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\PaymentProcessingSucceeded;
use App\Listeners\SendNewOrderPlacedNotification;
use App\Listeners\SendOrderDetailsEmail;
use App\Listeners\UpdateBusinessCredit;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        PaymentProcessingSucceeded::class => [
            UpdateBusinessCredit::class,
        ],

        OrderPlaced::class => [
            SendNewOrderPlacedNotification::class,
            SendOrderDetailsEmail::class,
        ],

        ThreadReceivedNewReply::class => [
            SendReceivedNewReplyNotification::class,
        ],
    ];
}
