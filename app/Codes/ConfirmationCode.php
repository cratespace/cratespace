<?php

namespace App\Codes;

class ConfirmationCode extends Code
{
    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected string $characterPool = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    /**
     * Generate a new unique and random code.
     *
     * @return string
     */
    public static function generate(): string
    {
        return substr(str_shuffle(str_repeat(
            $this->characterPool,
            self::CHARACTER_LENGTH
        )), 0, self::CHARACTER_LENGTH);
    }
}
