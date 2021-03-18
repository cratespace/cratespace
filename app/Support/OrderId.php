<?php

namespace App\Support;

class OrderId extends Uid
{
    /**
     * Generate a new and unique code.
     *
     * @param array[] $arguments
     *
     * @return string
     */
    public static function generate(...$arguments): string
    {
        return substr(str_shuffle(str_repeat(
            static::$characterPool,
            self::CHARACTER_LENGTH
        )), 0, self::CHARACTER_LENGTH);
    }
}
