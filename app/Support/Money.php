<?php

namespace App\Support;

use Money\Currency;
use Money\Money as PHPMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

class Money
{
    /**
     * Format mony value from integer "cents" to proper currency format.
     *
     * @param int $amount
     *
     * @return string
     */
    public static function format(int $amount): string
    {
        $formatter = new IntlMoneyFormatter(
            new \NumberFormatter(config('app.locale'), \NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $formatter->format(
            new PHPMoney($amount, new Currency(config('defaults.currency')))
        );
    }
}
