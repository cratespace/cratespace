<?php

namespace App\Http\Requests\Business;

use App\Models\User;
use Illuminate\Validation\Rule;
use Cratespace\Sentinel\Http\Requests\Request;

class BusinessRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->isAllowed('manage', new User(), false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesFor([
            'register',
            'business',
            'address',
        ], [
            'type' => [
                'required',
                'string',
                Rule::in(['business']),
            ],
        ]);
    }
}
