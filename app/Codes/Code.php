<?php

namespace App\Codes;

abstract class Code
{
    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected string $characterPool;

    /**
     * Default UID character length.
     */
    public const CHARACTER_LENGTH = 24;

    /**
     * Generate a new unique and random code.
     *
     * @return string
     */
    abstract public static function generate(): string;
}
