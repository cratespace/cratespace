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
        return $user->is($order->customer);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Order $order
     *
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        return $user->is($order->customer);
    }
}
