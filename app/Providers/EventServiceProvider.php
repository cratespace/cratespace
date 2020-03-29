<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\UpdateBusinessCredit;
use App\Listeners\SendOrderDetailsEmail;
use App\Events\PaymentProcessingSucceeded;
use App\Listeners\SendNewOrderPlacedNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
            UpdateBusinessCredit::class
        ],

        OrderPlaced::class => [
            SendNewOrderPlacedNotification::class,
            SendOrderDetailsEmail::class,
        ],
    ];
}
