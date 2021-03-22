<?php

namespace Tests\Unit\Models;

use App\Services\Stripe\Resource;

class StripeResourceStub extends Resource
{
    /**
     * Resource index for usage with Stripe.
     *
     * @var string
     */
    protected static $index = 'mock_reosurce';

    /**
     * Resource specific attributes.
     *
     * @var array
     */
    protected static $attributes = ['name'];
}
