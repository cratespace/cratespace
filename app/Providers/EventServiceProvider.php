<?php

namespace App\Providers;

use App\Events\OrderPlacedEvent;
use Illuminate\Support\Facades\Event;
use App\Events\TicketReceivedNewReply;
use Illuminate\Auth\Events\Registered;
use App\Events\OrderStatusUpdatedEvent;
use App\Events\SuccessfullyChargedEvent;
use App\Listeners\CreditBusinessAccount;
use App\Listeners\SendNewOrderNotification;
use App\Listeners\SendOrderPlacedNotification;
use App\Listeners\SendOrderStatusUpdatedNotification;
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
        // For business users.
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // For business users.
        SuccessfullyChargedEvent::class => [
            CreditBusinessAccount::class,
            SendNewOrderNotification::class,
        ],

        // For customers.
        OrderPlacedEvent::class => [
            SendOrderPlacedNotification::class,
        ],

        // For customers.
        OrderStatusUpdatedEvent::class => [
            SendOrderStatusUpdatedNotification::class,
        ],

        // For support request customer.
        TicketReceivedNewReply::class => [],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
