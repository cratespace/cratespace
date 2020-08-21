<?php

namespace App\Presenters\Traits;

use App\Support\Formatter;

trait FormatsMoney
{
    /**
     * Convert given amount from cents to money format.
     *
     * @param int $amount
     *
     * @return string
     */
    protected function formatMoney(?int $amount = null): string
    {
        return Formatter::money($amount ?? 0);
    }
}
