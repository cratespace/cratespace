<?php

namespace App\Providers;

use Laravel\Fortify\Fortify;
use App\Actions\Fortify\DeleteUser;
use App\Actions\Fortify\CreateNewUser;
use App\Contracts\Actions\DeletesUsers;
use Illuminate\Support\ServiceProvider;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Authentication actions.
     *
     * @var array
     */
    protected static array $actions = [
        'createUsersUsing' => CreateNewUser::class,
        'updateUserProfileInformationUsing' => UpdateUserProfileInformation::class,
        'updateUserPasswordsUsing' => UpdateUserPassword::class,
        'resetUserPasswordsUsing' => ResetUserPassword::class,
    ];

    /**
     * Authentication views.
     *
     * @var array
     */
    protected static array $views = [
        'loginView' => 'auth.login',
        'registerView' => 'auth.register',
        'verifyEmailView' => 'auth.verify-email',
        'requestPasswordResetLinkView' => 'auth.request-password-reset',
        'resetPasswordView' => 'auth.reset-password',
        'confirmPasswordView' => 'auth.confirm-password',
        'twoFactorChallengeView' => 'auth.tfa-challenge',
    ];

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
        $this->registerAuthActions();
        $this->registerAuthViews();
    }

    /**
     * Register user authentication action classes.
     *
     * @return void
     */
    protected function registerAuthActions(): void
    {
        foreach (static::$actions as $action => $actionClass) {
            Fortify::$action($actionClass);
        }

        $this->app->singleton(DeletesUsers::class, DeleteUser::class);
    }

    /**
     * Register user authentication views.
     *
     * @return void
     */
    protected function registerAuthViews(): void
    {
        foreach (static::$views as $viewMethod => $view) {
            Fortify::$viewMethod(fn () => view($view));
        }
    }
}
