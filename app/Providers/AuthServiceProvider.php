<?php

namespace App\Providers;

use App\Models\User;
use App\Auth\Authenticator;
use App\Auth\Api\Permission;
use App\Policies\UserPolicy;
use App\Auth\Actions\DeleteUser;
use App\Auth\Actions\CreateNewUser;
use App\Auth\TwoFactorAuthenticator;
use App\Contracts\Auth\DeletesUsers;
use Illuminate\Support\Facades\Auth;
use App\Auth\Actions\AuthenticateUser;
use App\Auth\Actions\ResetUserPassword;
use App\Auth\Actions\UpdateUserProfile;
use App\Contracts\Auth\CreatesNewUsers;
use App\Auth\Actions\UpdateUserPassword;
use App\Auth\Middleware\RedirectIfLocked;
use App\Contracts\Auth\AuthenticatesUsers;
use App\Contracts\Auth\ResetsUserPasswords;
use App\Contracts\Auth\UpdatesUserProfiles;
use App\Contracts\Auth\UpdatesUserPasswords;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Auth\Middleware\AttemptToAuthenticate;
use App\Auth\Middleware\EnsureLoginIsNotThrottled;
use App\Auth\Middleware\PrepareAuthenticatedSession;
use App\Auth\Middleware\RedirectIfTwoFactorAuthenticatable;
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
     * Authenticated user action classes.
     *
     * @var array
     */
    protected static array $authUserActions = [
        CreatesNewUsers::class => CreateNewUser::class,
        AuthenticatesUsers::class => AuthenticateUser::class,
        TwoFactorAuthenticatorContract::class => TwoFactorAuthenticator::class,
        ResetsUserPasswords::class => ResetUserPassword::class,
        UpdatesUserPasswords::class => UpdateUserPassword::class,
        UpdatesUserProfiles::class => UpdateUserProfile::class,
        DeletesUsers::class => DeleteUser::class,
    ];

    /**
     * User sign in process actions.
     *
     * @var array
     */
    public static array $authenticationMiddleware = [
        EnsureLoginIsNotThrottled::class,
        RedirectIfLocked::class,
        RedirectIfTwoFactorAuthenticatable::class,
        AttemptToAuthenticate::class,
        PrepareAuthenticatedSession::class,
    ];

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
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
        $this->configurePermissions();

        $this->registerPolicies();
    }

    /**
     * Register authentication guard to be used for application authentication.
     *
     * @return void
     */
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
        foreach (static::$authUserActions as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions(): void
    {
        Permission::defaultApiTokenPermissions(['read']);

        Permission::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
