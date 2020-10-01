<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AuthorizesRequest;
use App\Http\Requests\Traits\HasValidationRules;

class SpaceRequest extends FormRequest
{
    use AuthorizesRequest;
    use HasValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->space) {
            return $this->resourceBelongsToUser($this->space);
        }

        return $this->authenticated();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $additionalRules = ! is_null($this->space)
            ? ['code' => ['unique:spaces,code', 'exists:spaces']]
            : [];

        return $this->getRulesFor('space', $additionalRules);
    }

    /**
     * Filter out null values from validated data.
     *
     * @return array
     */
    public function validatedWithoutNulls(): array
    {
        return array_filter($this->validated(), function ($value) {
            return $value !== null;
        });
    }
}
