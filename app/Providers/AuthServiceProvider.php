<?php

namespace App\Providers;

use App\Auth\Authenticator;
use App\Auth\Actions\CreateNewUser;
use App\Auth\TwoFactorAuthenticator;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Auth\CreatesNewUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Contracts\Auth\Authenticator as AuthenticatorContract;
use App\Contracts\Auth\TwoFactorAuthenticator as TwoFactorAuthenticatorContract;
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
     * User authentication classes.
     *
     * @var array
     */
    protected static array $authenticators = [
        CreatesNewUsers::class => CreateNewUser::class,
        AuthenticatorContract::class => Authenticator::class,
        TwoFactorAuthenticatorContract::class => TwoFactorAuthenticator::class,
    ];

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
        foreach (static::$authenticators as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }
}
