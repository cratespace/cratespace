<?php

namespace App\Support;

use Hashids\Hashids;
use InvalidArgumentException;
use App\Contracts\Support\Generator;

class HashidsCodeGenerator implements Generator
{
    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected $characterPool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Default UID character length.
     */
    public const CHARACTER_LENGTH = 24;

    /**
     * Generator options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        return $this->hashIds()->encode($this->options['id']);
    }

    /**
     * Create new instance of HasId generator.
     *
     * @return \HashIds\HashIds
     */
    protected function hashIds(): Hashids
    {
        return new Hashids($this->salt(), self::CHARACTER_LENGTH, $this->characterPool);
    }

    /**
     * Get salt option.
     *
     * @return string
     */
    protected function salt(): string
    {
        $salt = $this->options['salt'];

        if (!isset($salt) || $salt !== config('app.key')) {
            throw new InvalidArgumentException('Invalid salt data.');
        }

        return $salt;
    }

    /**
     * Set generator options.
     *
     * @param array $options
     */
    public function setOptions(array $options = []): void
    {
        $this->options = $options;
    }
}
