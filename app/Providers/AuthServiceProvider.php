<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use App\Policies\UserPolicy;
use App\Policies\OrderPolicy;
use App\Policies\SpacePolicy;
use Illuminate\Support\Facades\Gate;
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
        Space::class => SpacePolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->bootObservers();

        Gate::before(function (User $user, string $ability) {
            if ($user->abilities()->contains($ability)) {
                return true;
            }
        });
    }

    /**
     * Boot all available observers.
     *
     * @return void
     */
    protected function bootObservers(): void
    {
    }
}
