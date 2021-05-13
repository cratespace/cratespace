<?php

namespace App\Providers;

use App\Models\User;
use App\Orders\Order;
use App\Models\Invitation;
use App\Policies\UserPolicy;
use App\Products\Line\Space;
use App\Policies\OrderPolicy;
use App\Policies\SpacePolicy;
use App\Policies\InvitationPolicy;
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
        Invitation::class => InvitationPolicy::class,
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
}
