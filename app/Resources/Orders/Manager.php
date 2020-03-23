<?php

namespace App\Resources\Orders;

use App\Models\User;
use App\Models\Order;
use App\Models\Space;

class Manager
{
    /**
     * The space being purchased.
     *
     * @var \App\Models\Space
     */
    protected $space;

    /**
     * The business the space being purchased beolgs to.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * The order insatcne ebeing processed.
     *
     * @var \App\Models\Order
     */
    protected $order;

    /**
     * Process order.
     *
     * @param  array  $data
     * @return void
     */
    public function process(array $data)
    {
        $this->processPayment()
            ->createOrder($data)
            ->notifyBusiness()
            ->sendOrderDetailsToCustomer($data['email']);
    }

    /**
     * Process payment.
     *
     * @return \App\Resources\Orders\Manager
     */
    protected function processPayment()
    {
        return $this;
    }

    /**
     * Save order to database.
     *
     * @param  array  $data
     * @return \App\Resources\Orders\Manager
     */
    protected function createOrder(array $data)
    {
        $this->space = $this->getSpaceDetails($data['space_id']);

        $this->order = $this->space->user->orders()->create(
            array_merge($data, $this->calculatePricing())
        );

        return $this;
    }

    /**
     * Notify relevant business of order placed.
     *
     * @return \App\Resources\Orders\Manager
     */
    protected function notifyBusiness()
    {
        // $this->sapce->user->notify($this->order);

        return $this;
    }

    /**
     * Send customer order details by email.
     */
    protected function sendOrderDetailsToCustomer($email)
    {
        // (new Email($email))->send($this->order);
    }

    /**
     * Identify space being purchased.
     *
     * @param  int $spaceId
     * @return \App\Models\Space
     */
    public function getSpaceDetails($spaceId)
    {
        return Space::findOrFail($spaceId);
    }

    /**
     * Calculate relevant pricing.
     *
     * @return array
     */
    protected function calculatePricing()
    {
        return app('purchase')->make($this->space);
    }
}
