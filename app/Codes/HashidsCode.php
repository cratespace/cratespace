<?php

namespace App\Codes;

use Hashids\Hashids;
use InvalidArgumentException;

class HashidsCode extends Code
{
    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected string $characterPool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Hash ID salt.
     *
     * @var string
     */
    protected string $salt;

    /**
     * Attribute to be hashed.
     *
     * @var string
     */
    protected string $id;

    /**
     * Generate a new unique and random code.
     *
     * @return string
     */
    public static function generate(): string
    {
        return $this->hashIds()->encode($this->id());
    }

    /**
     * Create new instance of HasId generator.
     *
     * @return \HashIds\HashIds
     */
    protected function hashIds(): Hashids
    {
        return new Hashids(
            $this->salt(),
            self::CHARACTER_LENGTH,
            $this->characterPool
        );
    }

    /**
     * Get salt option.
     *
     * @return string
     */
    protected function salt(): string
    {
        if (!isset($this->salt) || $this->salt !== config('app.key')) {
            throw new InvalidArgumentException('Invalid salt data.');
        }

        return $this->salt;
    }

    /**
     * Set salt option for hash ids.
     *
     * @param string $salt
     *
     * @return void
     */
    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    /**
     * ID to be hashed.
     *
     * @return string
     */
    protected function id(): string
    {
        return $this->id;
    }

    /**
     * Set ID to be hashed.
     *
     * @param string $id
     *
     * @return void
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }
}
