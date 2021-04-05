<?php

namespace App\Orders;

use App\Contracts\Orders\ConfirmationNumberGenerator;
use App\Contracts\Orders\ConfirmationNumberValidator;
use App\Orders\GenerateConfirmationNumber as Generator;
use App\Orders\ValidateConfirmationNumber as Validator;

class ConfirmationNumber implements ConfirmationNumberGenerator, ConfirmationNumberValidator
{
    public function __construct(Generator $generator, Validator $validator)
    {
        $this->generator = $generator;
        $this->validator = $validator;
    }

    /**
     * Generate order confirmation number.
     *
     * @return string
     */
    public function generate(): string
    {
        return $this->generator->generate();
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
        return $this->validator->validate($confirmationNumber);
    }
}
