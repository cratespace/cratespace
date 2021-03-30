<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\Order $order
     *
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        return $user->is($order->user);
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
        if ($user->is($order->user) || $user->is($order->customer)) {
            return $order->canCancel();
        }

        return false;
    }
}
