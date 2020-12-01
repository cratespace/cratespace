<?php

namespace App\Codes;

class UidCode extends Code
{
    /**
     * Generate a new unique and random code.
     *
     * @return string
     */
    public static function generate(): string
    {
        $uuid = date('YmdHis') . substr(explode(' ', microtime())[0], 2, 8) . rand(100000000000, 999999999999);

        return substr($uuid, 0, 8) . '-' . substr($uuid, 8, 4) . '-' . substr($uuid, 12, 4) . '-' . substr($uuid, 16, 4) . '-' . substr($uuid, 20, 12);
    }
}
