<?php

namespace App\Models\Concerns;

use App\Models\Order;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Auth;

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
        $order = $this->order()->create(
            $this->defaultOrderDetails($details)
        );

        OrderPlaced::dispatch($order);

        return $order;
    }

    /**
     * Create order details.
     *
     * @param array $details
     *
     * @return array
     */
    protected function defaultOrderDetails(array $details): array
    {
        return array_merge($details, [
            'price' => $this->price,
            'tax' => $this->tax,
            'total' => $this->fullPrice(),
            'user_id' => $this->user_id,
            'customer_id' => Auth::id(),
        ]);
    }
}
