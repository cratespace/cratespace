<?php

namespace App\Http\Services;

abstract class Service
{
    /**
     * Provide with service.
     *
     * @return mixed
     */
    abstract public function get();
}
