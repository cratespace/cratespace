<?php

namespace App\Http\Requests\Customer;

use Cratespace\Sentinel\Http\Requests\Request;

class CancelOrderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->isAllowed('view', $this->route('order'), false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ['password' => ['required', 'string']];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->afterValidation($this->validatePassword());

        $this->setErrorBag('deleteUser');
    }
}
