<?php

namespace App\Codes;

use Hashids\Hashids;
use Cratespace\Sentinel\Codes\Code;

class HashCode extends Code
{
    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected static $characterPool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Default UID character length.
     */
    public const CHARACTER_LENGTH = 24;

    /**
     * Generate a new and unique code.
     *
     * @return string
     */
    public static function generate(): string
    {
        $hash = new Hashids(
            config('app.key'),
            self::CHARACTER_LENGTH,
            static::$characterPool
        );

        return $hash->encode(func_get_arg(0));
    }
}
