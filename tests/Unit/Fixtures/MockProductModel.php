<?php

namespace Tests\Unit\Fixtures;

use App\Models\Traits\Marketable;
use App\Contracts\Purchases\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MockProductModel extends Model implements Product
{
    use Marketable;

    protected $table = 'mock_products';

    protected $guarded = [];

    public function order(): HasOne
    {
        return $this->hasOne(MockOrderModel::class, 'mock_product_id');
    }

    /**
     * Purchase this product using the given details.
     *
     * @param array $details
     *
     * @return mixed
     */
    public function purchase(array $details)
    {
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
    }
}
