<?php

namespace App\Contracts\Actions\Billing;

interface MakesPurchase
{
    /**
     * Purchase given product using the given details.
     *
     * @param array $details
     * @param mixed $product
     *
     * @return mixed
     */
    public function purchase(array $details, $product);
}
