<?php

namespace App\Orders;

use App\Orders\Validators\LengthValidator;
use App\Orders\Validators\AmbiguityValidator;
use App\Orders\Validators\CharacterValidator;
use App\Orders\Validators\UniquenessValidator;
use App\Contracts\Orders\ConfirmationNumberValidator;

class ValidateConfirmationNumber extends AbstractConfirmationNumber implements ConfirmationNumberValidator
{
    /**
     * The validators used by the routes.
     *
     * @var array
     */
    protected static $validators = [];

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
}
