<?php

namespace App\Providers;

use App\Actions\Fortify\DeleteUser;
use App\Contracts\Actions\DeletesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
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
    }

    /**
     * Register user authentication action classes.
     *
     * @return void
     */
    protected function registerAuthActions(): void
    {
        $this->app->singleton(DeletesUsers::class, DeleteUser::class);
    }
}
