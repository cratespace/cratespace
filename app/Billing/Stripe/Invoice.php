<?php

namespace App\Billing\Stripe;

use App\Support\Attribute;
use App\Contracts\Billing\Invoice as InvoiceContract;

class Invoice extends Attribute implements InvoiceContract
{
    /**
     * Attribute identifier.
     *
     * @var string
     */
    protected $name = 'invoice';
}
