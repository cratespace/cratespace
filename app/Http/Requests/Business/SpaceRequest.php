<?php

namespace App\Http\Requests\Business;

use Cratespace\Sentinel\Http\Requests\Request;

class SpaceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if ($this->route('space')) {
            return $this->isAllowed('manage', $this->space, false);
        }

        return $this->isAuthenticated('Business');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesFor('space');
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['user_id' => $this->user()->id]);
    }
}
