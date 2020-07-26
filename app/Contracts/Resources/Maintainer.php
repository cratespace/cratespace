<?php

namespace App\Contracts\Resources;

interface Maintainer
{
    /**
     * Run the maintenance routine.
     *
     * @return void
     */
    public function runMaintenance(): void;
}
