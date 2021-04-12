<?php

namespace Tests\Fixtures;

use Throwable;
use Mockery as m;
use App\Models\User;
use App\Contracts\Billing\Order;
use App\Products\AbstractProduct;
use App\Contracts\Billing\Payment;
use App\Contracts\Billing\Product;

class MockProduct extends AbstractProduct implements Product
{
    /**
     * Get the owner of the product.
     *
     * @return mixed
     */
    public function merchant()
    {
        try {
            return User::factory()->asBusiness()->create();
        } catch (Throwable $e) {
            return (object) [
                'business' => 'Parochial House',
                'name' => 'Father Jack Hackett',
                'email' => 'fr.j.hackett@craggyisle.com',
                'phone' => '0712345678',
                'password' => 'dontTellMeImStillInThatFekingIsland',
                'type' => 'business',
                'line1' => 'Glenquin',
                'city' => 'Killinaboy',
                'state' => 'Munster',
                'country' => 'Ireland',
                'postal_code' => '48161',
                'registration_number' => '01234567',
                'mcc' => '4798',
            ];
        }
    }

    /**
     * Reserve product for customer.
     *
     * @return void
     */
    public function reserve(): void
    {
        $this->reservedAt = now();
    }

    /**
     * Release space from order.
     *
     * @return void
     */
    public function release(): void
    {
        $this->reservedAt = null;
    }

    /**
     * Get full amount inclusive of tax for product in integer value.
     *
     * @return int
     */
    public function fullAmount(): int
    {
        return $this->details['amount'];
    }

    /**
     * Place an order for the product.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return \App\Contracts\Billing\Order
     */
    public function placeOrder(Payment $payment): Order
    {
        $order = m::mock(Order::class);

        $order->payment = $payment;

        return $this->order = $order;
    }

    /**
     * Determine if the product is available for purchase.
     *
     * @return bool
     */
    public function available(): bool
    {
        return is_null($this->reservedAt);
    }

    /**
     * Get the details regarding the product.
     *
     * @return array
     */
    public function details(): array
    {
        return array_merge($this->details, [
            'merchant' => $this->merchant()->id,
            'name' => $this->name,
        ]);
    }

    /**
     * Get the order associated with the product.
     *
     * @return \App\Contracts\Billing\Order
     */
    public function getOrderDetails(): Order
    {
        return $this->order;
    }

    /**
     * Determine if the product is nearing it's expiration.
     *
     * @return bool
     */
    public function nearingExpiration(): bool
    {
        return false;
    }

    /**
     * Destroy the mock product instance.
     *
     * @return void
     */
    public function __destruct()
    {
        m::close();
    }
}
