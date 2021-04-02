<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Cratespace\Sentinel\Http\Requests\Concerns\AuthorizesRequests;
use Cratespace\Sentinel\Http\Requests\Traits\InputValidationRules;

class BusinessRequest extends FormRequest
{
    use InputValidationRules;
    use AuthorizesRequests;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isAllowed('manage', $this->user(), false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesFor('business', array_merge(
            $this->getRulesFor('register', [
                'type' => ['required', 'string', Rule::in(['business'])],
            ]),
            $this->getRulesFor('address')
        ));
    }
}
