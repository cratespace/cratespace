<?php

namespace App\Support;

use Money\Money;
use Money\Currency;
use NumberFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

class Formatter
{
    /**
     * Format the given amount into a displayable currency.
     *
     * @param float       $amount
     * @param string|null $currency
     * @param string|null $locale
     *
     * @return string
     */
    public static function moneyFormat(float $amount, ?string $currency = null, ?string $locale = null)
    {
        $money = new Money($amount, new Currency(strtoupper($currency ?? 'usd')));

        $locale = $locale ?? 'en';

        $numberFormatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $moneyFormatter->format($money);
    }
}
