<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Order $order
     *
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->is($order->customer) || $user->is($order->business);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Order $order
     *
     * @return mixed
     */
    public function manage(User $user, Order $order)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->is($order->business);
    }
}
