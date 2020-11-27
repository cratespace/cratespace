<?php

namespace App\Actions\Fortify;

use App\Contracts\Auth\ValidatesInputs;

abstract class AuthActions
{
    /**
     * Validate given input data against relevant rules.
     *
     * @param string $entity
     * @param array  $input
     * @param array  $additionalRules
     *
     * @return array
     */
    public function validate(string $entity, array $input, array $additionalRules = []): array
    {
        return $this->getValidator()->validate($entity, $input, $additionalRules);
    }

    /**
     * Get input data validator.
     *
     * @return \App\Contracts\Auth\ValidatesInputs
     */
    protected function getValidator(): ValidatesInputs
    {
        return new ValidateInput();
    }
}
