<?php

namespace App\Contracts\Support;

interface Generator
{
    /**
     * Generate a desired result.
     *
     * @return \object|string|array|int
     */
    public function generate();
}
