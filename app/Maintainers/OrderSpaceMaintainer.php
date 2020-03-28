<?php

namespace App\Maintainers;

use App\Models\Order;

class OrderSpaceMaintainer extends Maintainer
{
    /**
     * Order Space states.
     *
     * @var array
     */
    protected $states = [
        'Pending' => 'Ordered',
        'Canceled' => 'Available',
        'Confirmed' => 'Ordered',
        'Completed' => 'Completed'
    ];

    /**
     * Run maintenance on resource.
     */
    public function run()
    {
        $this->maintainOrderSpaceStates();
    }

    /**
     * Maintain states between order and space.
     */
    protected function maintainOrderSpaceStates()
    {
        $this->getResource()->map(function ($order) {
            $order = Order::findOrFail($order->id);

            if (! $order->space->departed()) {
                $this->performStateManagement($order);
            }
        });
    }

    /**
     * Set status of space according to prder status.
     *
     * @param  \App\Models\Order  $order
     */
    protected function performStateManagement(Order $order)
    {
        foreach ($this->states as $orderState => $spaceState) {
            if ($order->status === $orderState) {
                $order->space->markAs($spaceState);
            }
        }
    }
}
