<?php

namespace Tests\Unit\Billing\fixtures;

use App\Contracts\Models\Priceable;
use Illuminate\Database\Eloquent\Model;

class PriceableResourceMock extends Model implements Priceable
{
    /**
     * Get all chargeable attributes.
     *
     * @return array
     */
    public function getCharges(): array
    {
        return [
            'price' => 10,
            'tax' => 2,
        ];
    }
}
