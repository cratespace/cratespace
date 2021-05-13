<?php

namespace App\Http\Requests\Business;

use App\Models\User;
use App\Rules\PhoneNumberRule;
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
        if ($this->method() !== 'PUT') {
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

        return $this->getRulesFor('business', [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'phone' => ['sometimes', 'string', new PhoneNumberRule()],
            'registration_number' => [
                'required',
                'max:255',
                Rule::unique('businesses', 'registration_number')
                    ->ignore($this->user()->id, 'user_id'),
            ],
            'mcc' => [
                'nullable',
                'max:255',
                Rule::unique('businesses', 'mcc')
                    ->ignore($this->user()->id, 'user_id'),
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
