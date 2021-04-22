<?php

namespace App\Providers;

use App\Support\Config;
use Illuminate\Http\RedirectResponse;
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
        $this->registerCustomConfigRepository();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRedirectResponse();
    }

    /**
     * Add redirect response macros.
     *
     * @return void
     */
    protected function configureRedirectResponse(): void
    {
        RedirectResponse::macro('banner', function ($message) {
            return $this->with('flash', [
                'bannerStyle' => 'success',
                'banner' => $message,
            ]);
        });

        RedirectResponse::macro('dangerBanner', function ($message) {
            return $this->with('flash', [
                'bannerStyle' => 'danger',
                'banner' => $message,
            ]);
        });
    }

    /**
     * Register custom config repository class.
     *
     * @return void
     */
    protected function registerCustomConfigRepository(): void
    {
        $this->app->singleton(Config::class);
    }
}
