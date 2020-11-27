<?php

namespace App\Actions\Fortify;

use App\Contracts\Auth\ValidatesInputs;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Concerns\InteractsWithRules;

class ValidateInput implements ValidatesInputs
{
    use InteractsWithRules;

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
        return Validator::make(
            $input, $this->getRules($entity, $additionalRules)
        )->validate();
    }
}
