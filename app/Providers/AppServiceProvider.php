<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Reply;
use App\Models\Space;
use App\Models\Ticket;
use App\Observers\OrderObserver;
use App\Observers\ReplyObserver;
use App\Observers\SpaceObserver;
use App\Observers\TicketObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All registered model observers.
     *
     * @var array
     */
    protected $observers = [
        Space::class => SpaceObserver::class,
        Order::class => OrderObserver::class,
        Ticket::class => TicketObserver::class,
        Reply::class => ReplyObserver::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMarkdownParser();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootObservers();
        $this->setHttpSchema();
        $this->extendCustomValidators();
    }

    /**
     * Register markdown parser.
     */
    public function registerMarkdownParser(): void
    {
        $this->app->singleton(Parsedown::class, function () {
            $parsedown = new \Parsedown();
            $parsedown->setSafeMode(true);

            return $parsedown;
        });
    }

    /**
     * Boot all available observers.
     *
     * @return void
     */
    protected function bootObservers(): void
    {
        foreach ($this->observers as $model => $observer) {
            $model::observe($observer);
        }
    }

    /**
     * Force application to use HTTPS.
     *
     * @return void
     */
    protected function setHttpSchema(): void
    {
        if ($this->app->isProduction()) {
            app('url')->forceScheme('https');
        }
    }

    /**
     * Add custom validator extensions.
     *
     * @return void
     */
    protected function extendCustomValidators(): void
    {
        Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }
}
