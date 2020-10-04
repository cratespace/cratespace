<?php

namespace App\Auth\TwoFactorAuthentication;

use Illuminate\Support\Str;
use App\Contracts\Support\Generator;

class RecoveryCode implements Generator
{
    /**
     * Array of generator options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Generate a desired result.
     *
     * @return mixed
     */
    public function generate()
    {
        return Str::random(10) . '-' . Str::random(10);
    }

    /**
     * Set generator options.
     *
     * @param array $options
     */
    public function setOptions(array $options = []): void
    {
        $this->options = $options;
    }
}
