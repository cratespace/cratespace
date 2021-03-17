<?php

namespace Tests\Unit\Fixtures;

use App\Models\Traits\Marketable;
use App\Contracts\Purchases\Product;
use Illuminate\Database\Eloquent\Model;

class MockProductModel extends Model implements Product
{
    use Marketable;

    protected $table = 'mock_products';

    protected $guarded = [];

    /**
     * Purchase this product using the given details.
     *
     * @param array $details
     *
     * @return mixed
     */
    public function purchase(array $details)
    {
        return $this->placeOrder($details);
    }

    /**
     * Place order for given product.
     *
     * @param array $details
     *
     * @return mixed
     */
    public function placeOrder(array $details)
    {
        return $details;
    }

    /**
     * Determine if the product has expired.
     *
     * @return bool
     */
    public function expired(): bool
    {
        return false;
    }

    /**
     * Reserve product for customer.
     *
     * @return void
     */
    public function reserve(): void
    {
    }

    /**
     * Release product from order.
     *
     * @return void
     */
    public function release(): void
    {
    }
}
