<?php

namespace App\Observers;

use App\Models\Customer;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     *
     * @param \App\Models\Customer $customer
     *
     * @return void
     */
    public function created(Customer $customer)
    {
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param \App\Models\Customer $customer
     *
     * @return void
     */
    public function updated(Customer $customer)
    {
    }
}
