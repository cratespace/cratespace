<?php

namespace App\Codes;

use Cratespace\Sentinel\Codes\Code;
use Cratespace\Sentinel\Contracts\Codes\CodeGenerator;

class ConfirmationNumber extends Code implements CodeGenerator
{
    /**
     * Generate a new and unique code.
     *
     * @return string
     */
    public function generate(): string
    {
        return substr(str_shuffle(str_repeat(
            static::$characterPool,
            self::CHARACTER_LENGTH
        )), 0, self::CHARACTER_LENGTH);
    }
}
