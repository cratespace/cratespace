<?php

namespace App\Contracts\Support;

interface Generator
{
    /**
     * Generate a unique code.
     *
     * @return string
     */
    public function generate(): string;
}
