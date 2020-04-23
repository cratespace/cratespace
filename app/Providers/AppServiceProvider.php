<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
<<<<<<< HEAD
        $this->registerMarkdowParser();
=======
        $this->registerMArkdowParser();
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register markdown parser.
     */
<<<<<<< HEAD
    protected function registerMarkdowParser()
=======
    protected function registerMArkdowParser()
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
    {
        $this->app->bind('markdown.parser', function () {
            return new \Parsedown();
        });
    }
}
