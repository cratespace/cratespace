<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Cratespace\Sentinel\Http\Requests\Concerns\AuthorizesRequests;
use Cratespace\Sentinel\Http\Requests\Traits\InputValidationRules;

class SpaceRequest extends FormRequest
{
    use AuthorizesRequests;
    use InputValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('space')) {
            return $this->isAllowed('manage', $this->space);
        }

        return $this->isAuthenticated();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesFor('space');
    }
}
