<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\Invitation;
use App\Policies\UserPolicy;
use App\Auth\Guards\APIGuard;
use App\Policies\OrderPolicy;
use App\Policies\SpacePolicy;
use App\Actions\Auth\DeleteUser;
use App\Products\Products\Space;
use Illuminate\Auth\RequestGuard;
use App\Policies\InvitationPolicy;
use App\Actions\Auth\CreateNewUser;
use App\Providers\Traits\HasActions;
use Illuminate\Support\Facades\Auth;
use App\Actions\Auth\ConfirmPassword;
use App\Actions\Auth\AuthenticateUser;
use App\Actions\Auth\ResetUserPassword;
use App\Actions\Auth\UpdateUserProfile;
use App\Auth\Config\Auth as AuthConfig;
use App\Contracts\Actions\DeletesUsers;
use App\Actions\Auth\UpdateUserPassword;
use App\Auth\Middleware\DenyLockedAccount;
use App\Contracts\Actions\CreatesNewUsers;
use App\Contracts\Actions\ConfirmsPasswords;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Contracts\Actions\AuthenticatesUsers;
use App\Auth\Middleware\AttemptToAuthenticate;
use App\Contracts\Actions\ResetsUserPasswords;
use App\Contracts\Actions\UpdatesUserProfiles;
use App\Contracts\Actions\UpdatesUserPasswords;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Auth\Guard as AuthGuard;
use App\Auth\Middleware\EnsureLoginIsNotThrottled;
use App\Actions\Auth\ProvideTwoFactorAuthentication;
use App\Auth\Middleware\PrepareAuthenticatedSession;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use App\Contracts\Actions\ProvidesTwoFactorAuthentication;
use App\Auth\Middleware\RedirectIfTwoFactorAuthenticatable;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use HasActions;

    /**
     * The list of classes (pipes) to be used for the authentication pipeline.
     *
     * @var array
     */
    protected static $loginPipeline = [
        EnsureLoginIsNotThrottled::class,
        RedirectIfTwoFactorAuthenticatable::class,
        DenyLockedAccount::class,
        AttemptToAuthenticate::class,
        PrepareAuthenticatedSession::class,
    ];

    /**
     * The cratespace action classes.
     *
     * @var array
     */
    protected $actions = [
        AuthenticatesUsers::class => AuthenticateUser::class,
        CreatesNewUsers::class => CreateNewUser::class,
        ResetsUserPasswords::class => ResetUserPassword::class,
        UpdatesUserPasswords::class => UpdateUserPassword::class,
        UpdatesUserProfiles::class => UpdateUserProfile::class,
        DeletesUsers::class => DeleteUser::class,
        ConfirmsPasswords::class => ConfirmPassword::class,
        ProvidesTwoFactorAuthentication::class => ProvideTwoFactorAuthentication::class,
    ];

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Invitation::class => InvitationPolicy::class,
        Order::class => OrderPolicy::class,
        Space::class => SpacePolicy::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerAuthGuard();
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        $this->registerActions();

        $this->configureCratespaceGuard();
    }

    /**
     * Register default authentication guard implementation.
     *
     * @return void
     */
    protected function registerAuthGuard(): void
    {
        $this->app->bind(
            StatefulGuard::class,
            fn () => Auth::guard(AuthConfig::guard('web'))
        );
    }

    /**
     * Get the list of classes (pipes) to be used for the authentication pipeline.
     *
     * @return array
     */
    public static function loginPipeline(): array
    {
        return static::$loginPipeline;
    }

    /**
     * Configure the Cratespace authentication guard.
     *
     * @return void
     */
    protected function configureCratespaceGuard(): void
    {
        Auth::resolved(function (AuthFactory $auth) {
            $auth->extend('cratespace', function (
                Application $app,
                string $name,
                array $config
            ) use ($auth): AuthGuard {
                return tap(
                    $this->createCratespaceGuard($auth, $config),
                    function (AuthGuard $guard): void {
                        $this->app->refresh('request', $guard, 'setRequest');
                    }
                );
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
    protected function createCratespaceGuard(AuthFactory $auth, array $config): RequestGuard
    {
        return new RequestGuard(
            new APIGuard($auth, AuthConfig::expiration(), $config['provider']),
            $this->app['request'],
            $auth->createUserProvider($config['provider'] ?? null)
        );
    }
}
