<?php

namespace Tests\Unit\Fixtures;

use Mockery as m;
use App\Contracts\Purchases\Order;
use App\Contracts\Purchases\Product;
use Illuminate\Database\Eloquent\Model;

class MockOrderModel extends Model implements Order
{
    protected $table = 'mock_orders';

    protected $guarded = [];

    /**
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount(): string
    {
        return '$4.00';
    }

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount(): int
    {
        return 400;
    }

    /**
     * Determine the status of the order.
     *
     * @return string
     */
    public function status(): string
    {
        return 'successful';
    }

    /**
     * Cancel the order.
     *
     * @return void
     */
    public function cancel(): void
    {
    }

    /**
     * Get the product this order belongs to.
     *
     * @return \App\Contracts\Purchases\Product
     */
    public function product(): Product
    {
        return m::mock(Product::class);
    }
}
