<?php

namespace App\Codes;

abstract class Code
{
    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected $characterPool;

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

    /**
     * Set pool of characters to user when generating codes.
     *
     * @param string $characters
     *
     * @return void
     */
    public function setCharacterPool(string $characters): void
    {
        $this->characterPool = $characters;
    }
}
