<?php

namespace App\Contracts\Models;

interface Priceable
{
    /**
     * Get all chargeable attributes.
     *
     * @return array
     */
    public function getCharges(): array;
}
