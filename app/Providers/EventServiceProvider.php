<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\OrderStatusUpdated;
use App\Events\SuccessfullyCharged;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
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
        SuccessfullyCharged::class => [
            CreditBusinessAccount::class,
            SendNewOrderNotification::class,
        ],

        // For customers.
        OrderPlaced::class => [
            SendOrderPlacedNotification::class,
        ],

        // For customers.
        OrderStatusUpdated::class => [
            SendOrderStatusUpdatedNotification::class,
        ],
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
