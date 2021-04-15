<?php

namespace App\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\ShareInertiaData;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\EnsureFrontendRequestsAreStateful;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRedirectResponse();
        $this->configureMiddleware();
    }

    /**
     * Boot any Inertia related services.
     *
     * @return void
     */
    protected function configureMiddleware(): void
    {
        $kernel = $this->app->make(Kernel::class);

        $kernel->appendMiddlewareToGroup('web', ShareInertiaData::class);

        $kernel->appendToMiddlewarePriority(ShareInertiaData::class);
        $kernel->appendToMiddlewarePriority(HandleInertiaRequests::class);

        $kernel->prependToMiddlewarePriority(
            EnsureFrontendRequestsAreStateful::class
        );
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
}
