<?php

namespace App\Http\Controllers\Support\Concerns;

use App\Models\Customer;
use Illuminate\Http\Request;

trait CreatesNewCustomer
{
    /**
     * get existing customer or create new customer.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Models\Customer
     */
    protected function getCustomer(Request $request): Customer
    {
        return Customer::firstOrCreate($request->only((new Customer())->getFillable()));
    }
}
