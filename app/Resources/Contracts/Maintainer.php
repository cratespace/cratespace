<?php

namespace App\Resources\Contracts;

interface Maintainer
{
    /**
     * Run maintenance on resource.
     */
    public function run();
}
