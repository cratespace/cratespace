<?php

namespace App\Contracts\Services;

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
