<?php

namespace App\Support;

use RuntimeException;
use App\Contracts\Models\Priceable;

class Calculator
{
    /**
     * Calculate "total", "service-charge" and all relevant charges for resource.
     *
     * @return array
     */
    public static function payments(Priceable $resource): array
    {
        $charges = [];

        if (is_null($resource->price)) {
            throw new RuntimeException('Model does not have pricing attributes');
        }

        $charges = [
            'price' => $resource->getChargeAmountInCents($resource->price),
            'tax' => $resource->getChargeAmountInCents($resource->tax),
        ];
    }
}
