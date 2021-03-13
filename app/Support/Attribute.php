<?php

namespace App\Support;

abstract class Attribute
{
    /**
     * Attribute identifier.
     *
     * @var string
     */
    protected $name;

    /**
     * Format the given amount into a displayable currency.
     *
     * @param int $amount
     *
     * @return string
     */
    protected function formatAmount($amount): string
    {
        return Money::format($amount, $this->currency);
    }
}
