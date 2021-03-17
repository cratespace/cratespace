<?php

namespace Tests\Concerns;

use App\Models\User;
use App\Contracts\Purchases\Product;
use App\Actions\Purchases\PurchaseSpace;
use App\Actions\Purchases\GeneratePurchaseToken;

trait SupportsPurchase
{
    /**
     * Generate mock purchase token.
     *
     * @param \App\Contracts\Purchases\Product $product
     *
     * @return string
     */
    protected function generateToken(Product $product): string
    {
        return (new GeneratePurchaseToken())->generate($product->id());
    }

    /**
     * Create a user with customer role.
     *
     * @return \App\Models\User
     */
    protected function createCustomer(): User
    {
        return User::factory()->asCustomer()->create();
    }

    /**
     * Perform purchase of a product.
     *
     * @param \App\Contracts\Purchases\Product $product
     * @param array                            $details
     *
     * @return mixed
     */
    protected function makePurchase(Product $product, array $details)
    {
        return $this->app
            ->make(PurchaseSpace::class)
            ->purchase($product, $details);
    }
}
