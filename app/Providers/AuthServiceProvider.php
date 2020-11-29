<?php

namespace App\Providers;

use App\Auth\Login;
use App\Auth\Actions\CreateNewUser;
use Illuminate\Support\Facades\Auth;
use App\Auth\TwoFactorAuthentication;
use App\Contracts\Auth\Authenticator;
use App\Contracts\Auth\CreatesNewUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Contracts\Auth\TwoFactorAuthentication as TwoFactorAuthenticationContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Default user attribute to use as username.
     *
     * @var string
     */
    public const USERNAME = 'email';

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuthGuards();
        $this->registerAuthenticators();
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }

    protected function registerAuthGuards(): void
    {
        $this->app->bind(StatefulGuard::class, function () {
            return Auth::guard('web');
        });
    }

    /**
     * Register session authenticator.
     *
     * @return void
     */
    protected function registerAuthenticators(): void
    {
        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);
        $this->app->singleton(Authenticator::class, Login::class);
        $this->app->singleton(
            TwoFactorAuthentication::class,
            TwoFactorAuthenticationContract::class
        );
    }
}
