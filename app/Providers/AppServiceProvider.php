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
        $this->registerMarkdowParser();
    }

    /**
     * Register markdown parser.
     */
    protected function registerMarkdowParser()
    {
        $this->app->bind('markdown.parser', function () {
            return new \Parsedown();
        });
    }
}
