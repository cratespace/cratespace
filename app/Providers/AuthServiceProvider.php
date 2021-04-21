<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use App\Models\Invitation;
use App\Policies\UserPolicy;
use App\Policies\OrderPolicy;
use App\Policies\SpacePolicy;
use App\Actions\Auth\DeleteUser;
use App\Policies\InvitationPolicy;
use App\Actions\Auth\CreateNewUser;
use App\Providers\Traits\HasActions;
use Illuminate\Support\Facades\Auth;
use App\Actions\Auth\ConfirmPassword;
use App\Actions\Auth\AuthenticateUser;
use App\Actions\Auth\ResetUserPassword;
use App\Actions\Auth\UpdateUserProfile;
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
use App\Auth\Middleware\EnsureLoginIsNotThrottled;
use App\Actions\Auth\ProvideTwoFactorAuthentication;
use App\Auth\Middleware\PrepareAuthenticatedSession;
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
     * The sentinel action classes.
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
        Space::class => SpacePolicy::class,
        Order::class => OrderPolicy::class,
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
            fn () => Auth::guard(config('auth.defaults.guard'))
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
}
