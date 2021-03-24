<?php

namespace App\Contracts\Services;

use App\Support\Service;

interface Client
{
    /**
     * Create Stripe client instance.
     *
     * @param array[] $config
     *
     * @return mixed
     */
    public function make(array $config = []);
}
