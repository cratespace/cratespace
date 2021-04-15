<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use App\Models\Invitation;
use App\Policies\UserPolicy;
use App\Policies\OrderPolicy;
use App\Policies\SpacePolicy;
use Illuminate\Auth\RequestGuard;
use App\Policies\InvitationPolicy;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Auth\Guard as AuthGuard;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Invitation::class => InvitationPolicy::class,
        Space::class => SpacePolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }

    /**
     * Configure the Sentinel authentication guard.
     *
     * @return void
     */
    protected function configureGuard(): void
    {
        Auth::resolved(function (AuthFactory $auth) {
            $auth->extend('sentinel', function (Application $app, string $name, array $config) use ($auth): AuthGuard {
                return tap($this->createGuard($auth, $config), function (AuthGuard $guard): void {
                    $this->app->refresh('request', $guard, 'setRequest');
                });
            });
        });
    }

    /**
     * Register the guard.
     *
     * @param \Illuminate\Contracts\Auth\Factory $auth
     * @param array                              $config
     *
     * @return \Illuminate\Auth\RequestGuard
     */
    protected function createGuard(AuthFactory $auth, array $config): RequestGuard
    {
        return new RequestGuard(
            new Guard($auth, Config::expiration(), $config['provider']),
            $this->app['request'],
            $auth->createUserProvider($config['provider'] ?? null)
        );
    }
}
