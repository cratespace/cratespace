<?php

namespace App\Support;

use App\Contracts\Support\Generator;

class UidGenerator implements Generator
{
    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected $characterPool = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    /**
     * Default UID character length.
     */
    public const CHARACTER_LENGTH = 24;

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        return substr(
            str_shuffle(str_repeat($this->characterPool, self::CHARACTER_LENGTH)),
            0,
            self::CHARACTER_LENGTH
        );
    }
}
