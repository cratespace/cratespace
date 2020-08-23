<?php

namespace App\Http\Requests\Traits;

use Illuminate\Support\Facades\Config;
use App\Contracts\Validations\Validation;

trait HasValidationRules
{
    /**
     * Get the validation rules that apply to the resource.
     *
     * @param string $key
     * @param array  $additionalRules
     *
     * @return array
     */
    protected function getRulesFor(string $key, array $additionalRules = []): array
    {
        return array_merge(Config::get("rules.{$key}"), $additionalRules);
    }
}
