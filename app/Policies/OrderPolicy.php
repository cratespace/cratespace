<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage the model.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Order $order
     *
     * @return mixed
     */
    public function manage(User $user, Order $order)
    {
        return $user->is($order->user) || $user->hasRole('admin');
    }
}
