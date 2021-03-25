<?php

namespace App\Providers;

use App\Models\Space;
use App\Events\OrderPlaced;
use App\Events\OrderCanceled;
use App\Events\PaymentFailed;
use App\Listeners\MakePayout;
use App\Events\ProductReleased;
use App\Events\ProductReserved;
use App\Observers\SpaceObserver;
use App\Events\PaymentSuccessful;
use Illuminate\Auth\Events\Registered;
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

        PaymentSuccessful::class => [
            MakePayout::class,
        ],

        PaymentFailed::class => [],
        PaymentRefunded::class => [],

        ProductReserved::class => [],
        ProductReleased::class => [],

        OrderPlaced::class => [],
        OrderCanceled::class => [],
    ];

    /**
     * All model observers to be registered.
     *
     * @var array
     */
    protected $observers = [
        Space::class => SpaceObserver::class,
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
        foreach ($this->observers as $model => $observer) {
            $model::observe($observer);
        }
    }
}
