<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Concerns\InteractsWithRules;

abstract class AuthActions
{
    use InteractsWithRules;

    /**
     * Validate given input data against relevant rules.
     *
     * @param string      $entity
     * @param array       $input
     * @param array       $additionalRules
     * @param string|null $bag
     *
     * @return array
     */
    public function validate(string $entity, array $input, array $additionalRules = [], ?string $bag = null): array
    {
        $validator = Validator::make($input, $this->getRules(
            $entity, $additionalRules
        ));

        if (!is_null($bag)) {
            return $validator->validateWithBag($bag);
        }

        return $validator->validate();
    }
}
