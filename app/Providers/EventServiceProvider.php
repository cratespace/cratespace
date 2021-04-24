<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Invitation;
use App\Observers\UserObserver;
use App\Observers\OrderObserver;
use App\Observers\BusinessObserver;
use App\Observers\CustomerObserver;
use App\Observers\InvitationObserver;
use Illuminate\Support\Facades\Event;
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
    ];

    /**
     * All model observers to be registered.
     *
     * @var array
     */
    protected $observers = [
        User::class => UserObserver::class,
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
