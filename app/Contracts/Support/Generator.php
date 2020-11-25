<?php

namespace App\Contracts\Support;

interface Generator
{
    /**
     * Generate a desired result.
     *
     * @return mixed
     */
    public function generate();

    /**
     * Set generator options.
     *
     * @param array $options
     */
    public function setOptions(array $options = []): void;
}
