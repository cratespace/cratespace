<?php

namespace App\Contracts\Billing;

use App\Filters\OrderFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface Order extends Payment
{
    /**
     * Get the product associated with this order.
     *
     * @return \App\Contracts\Billing\Product
     */
    public function product(): Product;

    /**
     * Confirm order for customer.
     *
     * @return void
     */
    public function confirm(): void;

    /**
     * Cancel this order.
     *
     * @return void
     */
    public function cancel(): void;

    /**
     * List all latest orders.
     *
     * @param \App\Filters\OrderFilter|null $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function listing(?OrderFilter $filter = null): LengthAwarePaginator;
}
