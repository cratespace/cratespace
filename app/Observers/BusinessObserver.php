<?php

namespace App\Observers;

use App\Models\Business;

class BusinessObserver
{
    /**
     * Handle the Business "created" event.
     *
     * @param \App\Models\Business $business
     *
     * @return void
     */
    public function created(Business $business)
    {
    }

    /**
     * Handle the Business "updated" event.
     *
     * @param \App\Models\Business $business
     *
     * @return void
     */
    public function updated(Business $business)
    {
    }
}
