<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Invitation;
use App\Events\OrderPlaced;
use App\Events\PaymentFailed;
use App\Listeners\MakePayout;
use App\Events\OrderCancelled;
use App\Events\BusinessInvited;
use App\Events\ProductReleased;
use App\Events\ProductReserved;
use App\Observers\OrderObserver;
use App\Events\PaymentSuccessful;
use App\Observers\BusinessObserver;
use App\Observers\CustomerObserver;
use App\Observers\InvitationObserver;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendPaymentFailedNotification;
use App\Listeners\SendOrderCancelledNotification;
use App\Listeners\SendBusinessInvitedNotification;
use App\Listeners\SendPaymentRefundedNotification;
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

        BusinessInvited::class => [
            SendBusinessInvitedNotification::class,
        ],

        PaymentSuccessful::class => [
            MakePayout::class,
        ],

        PaymentFailed::class => [
            SendPaymentFailedNotification::class,
        ],

        PaymentRefunded::class => [
            SendPaymentRefundedNotification::class,
        ],

        ProductReserved::class => [],
        ProductReleased::class => [],

        OrderPlaced::class => [
            SendNewOrderPlacedNotification::class,
        ],

        OrderCancelled::class => [
            SendOrderCancelledNotification::class,
        ],
    ];

    /**
     * All model observers to be registered.
     *
     * @var array
     */
    protected $observers = [
        Order::class => OrderObserver::class,
        Business::class => BusinessObserver::class,
        Customer::class => CustomerObserver::class,
        Invitation::class => InvitationObserver::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerObservers();
    }

    /**
     * Programmatically register model observers.
     *
     * @return void
     */
    public function registerObservers(): void
    {
        collect($this->observers)->each(
            fn ($observer, $model) => $model::observe($observer)
        );
    }
}
