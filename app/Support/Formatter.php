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
     * Extract integers from the given string.
     *
     * @param string $string
     *
     * @return int
     */
    public static function getIntegerValues(string $string): int
    {
        return (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT);
    }

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

    /**
     * Parse markdown.
     *
     * @param string $content
     *
     * @return string
     */
    public static function parse(string $content): string
    {
        return app()->make(\Parsedown::class)->text($content);
    }

    /**
     * Trim large text body to size of an excerpt.
     *
     * @param string $content
     * @param int    $length
     *
     * @return string
     */
    public static function excerpt(string $content, int $length = 255): string
    {
        $content = preg_split('/<!-- more -->/m', $content, 2);
        $cleaned = trim(
            strip_tags(
                preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content[0]),
                '<code>'
            )
        );

        if (count($content) > 1) {
            return $content[0];
        }

        $truncated = substr($cleaned, 0, $length);

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated) . '...'
            : $cleaned;
    }
}
