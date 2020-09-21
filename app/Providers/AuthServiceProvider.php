<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use App\Models\Ticket;
use App\Policies\UserPolicy;
use App\Policies\OrderPolicy;
use App\Policies\SpacePolicy;
use App\Policies\TicketPolicy;
use App\Auth\Actions\DeleteUser;
use App\Auth\Actions\CreateNewUser;
use App\Contracts\Auth\DeletesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Auth\Actions\ResetUserPassword;
use App\Auth\Actions\UpdateUserProfile;
use App\Contracts\Auth\CreatesNewUsers;
use App\Auth\Actions\UpdateUserPassword;
use App\Contracts\Auth\UpdatesUserProfile;
use App\Contracts\Auth\ResetsUserPasswords;
use App\Contracts\Auth\UpdatesUserPasswords;
use Illuminate\Contracts\Auth\StatefulGuard;
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
        Ticket::class => TicketPolicy::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerStatefulGuard();
        $this->registerAuthActions();
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user, string $ability) {
            if ($user->abilities()->contains($ability)) {
                return true;
            }
        });
    }

    /**
     * Register stateful guard.
     *
     * @return void
     */
    protected function registerStatefulGuard(): void
    {
        $this->app->bind(StatefulGuard::class, function () {
            return Auth::guard('web');
        });
    }

    /**
     * Register user authentication action classes.
     *
     * @return void
     */
    protected function registerAuthActions(): void
    {
        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);
        $this->app->singleton(UpdatesUserProfile::class, UpdateUserProfile::class);
        $this->app->singleton(UpdatesUserPasswords::class, UpdateUserPassword::class);
        $this->app->singleton(ResetsUserPasswords::class, ResetUserPassword::class);
        $this->app->singleton(DeletesUsers::class, DeleteUser::class);
    }
}
