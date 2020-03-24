<?php

namespace App\Maintainers;

abstract class Maintainer
{
    /**
     * Run maintenance on resource.
     */
    abstract public function run();
}
