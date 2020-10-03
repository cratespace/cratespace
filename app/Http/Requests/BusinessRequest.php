<?php

namespace App\Http\Requests;

use App\Models\Business;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AuthorizesRequest;
use App\Http\Requests\Traits\HasValidationRules;

class BusinessRequest extends FormRequest
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
        return $this->resourceBelongsToUser($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesFor('business', [
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique((new Business())->getTable())->ignore(
                    auth()->id(),
                    'user_id'
                ),
            ],
        ]);
    }
}
