<?php

namespace App\Contracts\Auth;

interface ValidatesInputs
{
    /**
     * Validate given input data against relevant rules.
     *
     * @param string $entity
     * @param array  $input
     *
     * @return array
     */
    public function validate(string $entity, array $input): array;
}
