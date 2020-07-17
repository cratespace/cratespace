<?php

namespace App\Http\Requests\Traits;

use App\Contracts\Validations\Validation;

trait HasValidationRules
{
    /**
     * Get the validation rules that apply to the resource.
     *
     * @param array $additionalRules
     *
     * @return array
     */
    protected function getRules(array $additionalRules = []): array
    {
        return app()->make($this->getResourceValidationClass())
            ->rules($additionalRules);
    }

    /**
     * Get resource name in lowercase.
     *
     * @return string
     */
    protected function getResourceValidationClass(): string
    {
        return '\\App\\Validations\\' . str_replace('Request', 'Validation', class_basename($this));
    }
}
