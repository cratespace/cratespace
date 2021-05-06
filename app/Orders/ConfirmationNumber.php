<?php

namespace App\Orders;

use App\Orders\Validators\LengthValidator;
use App\Orders\Validators\AmbiguityValidator;
use App\Orders\Validators\CharacterValidator;
use App\Orders\Validators\UniquenessValidator;

class ConfirmationNumber
{
    /**
     * The validators used by the routes.
     *
     * @var array
     */
    protected static $validators = [];

    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected static $characterPool = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    /**
     * Default confirmation number character length.
     */
    public const CHARACTER_LENGTH = 24;

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

    /**
     * Validate the given order confirmation number.
     *
     * @param string $confirmationNumber
     *
     * @return bool
     */
    public function validate(string $confirmationNumber): bool
    {
        foreach (static::getValidators() as $validator) {
            if (! $validator->validate($confirmationNumber)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the route validators for the instance.
     *
     * @return array
     */
    public static function getValidators()
    {
        if (! empty(static::$validators)) {
            return static::$validators;
        }

        return static::$validators = [
            new CharacterValidator(), new LengthValidator(),
            new AmbiguityValidator(), new UniquenessValidator(),
        ];
    }

    /**
     * Set order confirmation number validators.
     *
     * @param array $validators
     *
     * @return void
     */
    public static function setValidators(array $validators = []): void
    {
        static::$validators = $validators;
    }

    /**
     * Get the character pool used to generate confirmation numbers.
     *
     * @return string
     */
    public static function characterPool(): string
    {
        return static::$characterPool;
    }

    /**
     * Set the character pool that will be used to generate confirmation numbers.
     *
     * @param string @pool
     *
     * @return void
     */
    public static function setCharacterPool(string $pool): void
    {
        static::$characterPool = $pool;
    }
}
