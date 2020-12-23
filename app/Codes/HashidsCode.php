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
    protected $characterPool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Hash ID salt.
     *
     * @var string
     */
    protected $salt;

    /**
     * Attribute to be hashed.
     *
     * @var string
     */
    protected $id;

    /**
     * Generate a new unique and random code.
     *
     * @return string
     */
    public static function generate(): string
    {
        $generator = new self();

        [$id, $salt] = func_get_args();

        return $generator->setId($id)
            ->setSalt($salt)
            ->hashIds()
            ->encode($generator->id());
    }

    /**
     * Create new instance of Hashid generator.
     *
     * @return \Hashids\Hashids
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
        if (! isset($this->salt) || $this->salt !== config('app.key')) {
            throw new InvalidArgumentException('Invalid salt data.');
        }

        return $this->salt;
    }

    /**
     * Set salt option for hash ids.
     *
     * @param string $salt
     *
     * @return \Hashids\Hashids\HashidsCode
     */
    public function setSalt(string $salt): HashidsCode
    {
        $this->salt = $salt;

        return $this;
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
     * @return \Hashids\Hashids\HashidsCode
     */
    public function setId(string $id): HashidsCode
    {
        $this->id = $id;

        return $this;
    }
}
