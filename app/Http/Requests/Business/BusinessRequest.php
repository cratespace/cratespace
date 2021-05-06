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
        return $this->isAllowed('manage', $this->user(), false);
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

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->method() === 'PUT') {
            $this->setErrorBag('updateBusinessInformation');
        }
    }
}
