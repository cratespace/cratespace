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

    /**
     * Set generator options.
     *
     * @param array $options
     */
    public function setOptions(array $options = []): void;
}
