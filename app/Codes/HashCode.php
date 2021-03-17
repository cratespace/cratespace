<?php

namespace App\Codes;

use Hashids\Hashids;
use Cratespace\Sentinel\Codes\Code;
use Cratespace\Sentinel\Contracts\Codes\CodeGenerator;

class HashCode extends Code implements CodeGenerator
{
    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected static $characterPool = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';

    /**
     * Generate a new and unique code.
     *
     * @return string
     */
    public function generate(): string
    {
        $hash = new Hashids(
            config('app.key'),
            self::CHARACTER_LENGTH,
            static::$characterPool
        );

        return $hash->encode(func_get_arg(0));
    }
}
