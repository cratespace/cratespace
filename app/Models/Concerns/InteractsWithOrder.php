<?php

namespace App\Models\Concerns;

use App\Models\Order;

trait InteractsWithOrder
{
    /**
     * Mark space as booked and create order details.
     *
     * @param array $details
     *
     * @return \App\Models\Order
     */
    public function placeOrder(array $details): Order
    {
        $this->reserve();

        return $this->order()->create(array_merge($details, [
            'price' => $this->price,
            'tax' => $this->tax,
            'total' => $this->fullPrice(),
            'user_id' => $this->user->id,
        ]));
    }
}
