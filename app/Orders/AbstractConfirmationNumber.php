<?php

namespace App\Orders;

abstract class AbstractConfirmationNumber
{
    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected static $characterPool = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    /**
     * Default confirmation number character length.
     */
    public const CHARACTER_LENGTH = 24;

    /**
     * Get the character pool used to generate confirmation numbers.
     *
     * @return string
     */
    public static function characterPool(): string
    {
        return static::$characterPool;
    }

    /**
     * Set the character pool that will be used to generate confirmation numbers.
     *
     * @param string @pool
     *
     * @return void
     */
    public static function setCharacterPool(string $pool): void
    {
        static::$characterPool = $pool;
    }
}
