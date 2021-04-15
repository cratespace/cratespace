<?php

namespace App\Orders;

use App\Contracts\Orders\ConfirmationNumberGenerator;

class GenerateConfirmationNumber extends AbstractConfirmationNumber implements ConfirmationNumberGenerator
{
    /**
     * Generate order confirmation number.
     *
     * @return string
     */
    public function generate(): string
    {
        return substr(str_shuffle(str_repeat(
            static::$characterPool, self::CHARACTER_LENGTH
        )), 0, self::CHARACTER_LENGTH);
    }
}
