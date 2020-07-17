<?php

namespace App\Contracts\Validations;

interface Validation
{
    /**
     * Get relevant resource for currently accessing resource.
     *
     * @param array $additionalRules
     *
     * @return array
     */
    public function rules(array $additionalRules = []): array;
}
