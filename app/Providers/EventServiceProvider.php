<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\BusinessInvited;
use App\Events\ProductReleased;
use App\Events\ProductReserved;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * All model observers to be registered.
     *
     * @var array
     */
    protected $observers = [];

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        BusinessInvited::class => [],

        ProductReserved::class => [],
        ProductReleased::class => [],

        OrderPlaced::class => [],
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
    protected function registerObservers(): void
    {
        collect($this->observers)->each(
            fn ($observer, $model) => $model::observe($observer)
        );
    }
}
