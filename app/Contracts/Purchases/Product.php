<?php

namespace App\Contracts\Purchases;

interface Product
{
    /**
     * Place order for given product.
     *
     * @param array $details
     *
     * @return mixed
     */
    public function placeOrder(array $details);

    /**
     * Get full price or product inclusive of all additional charges.
     *
     * @return int
     */
    public function fullPrice(): int;

    /**
     * Get product business details.
     *
     * @param string|null $attribute
     *
     * @return mixed
     */
    public function business(?string $attribute = null);
}
