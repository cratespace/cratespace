<?php

namespace Tests\Concerns;

use App\Models\Space;
use App\Actions\CreateNewOrder;
use App\Contracts\Actions\CreatesNewOrders;

trait CanPlaceOrder
{
    /**
     * Create new order.
     *
     * @param \App\Models\Space $space
     * @param array|null        $data
     *
     * @return \App\Models\Order
     */
    protected function createNewOrder(Space $space, ?array $data = null)
    {
        $data = $data ?? $this->orderDetails($this->getCardDetails());

        return $this->orderCreator()->create($space, $data);
    }

    /**
     * Get instance of order creator action class.
     *
     * @return \App\Contracts\Actions\CreatesNewOrders
     */
    protected function orderCreator(): CreatesNewOrders
    {
        if (app()->bound(CreatesNewOrders::class)) {
            return app()->make(CreateNewOrder::class);
        }

        return app()->make(CreateNewOrder::class);
    }

    /**
     * Fake a JSON post request to purchase/order a space.
     *
     * @param \App\Models\Space $space
     * @param array             $parameters
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function orderSpace(Space $space, array $parameters = [])
    {
        $this->calculateCharges($space);

        return $this->postJson("/spaces/{$space->code}/orders", $parameters);
    }

    /**
     * Get fake order details.
     *
     * @param array $attributes
     *
     * @return array
     */
    protected function orderDetails(array $attributes = []): array
    {
        return array_merge([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ], $attributes);
    }

    /**
     * Get fake credit card details.
     *
     * @return array
     */
    protected function getCardDetails(): array
    {
        return [
            'number' => '4242424242424242',
            'exp_month' => 1,
            'exp_year' => date('Y') + 1,
            'cvc' => '123',
        ];
    }
}
