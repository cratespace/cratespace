<?php

namespace App\Http\Requests;

use Throwable;
use App\Rules\PaymentMethodRule;
use App\Rules\PurchaseTokenRule;
use Illuminate\Foundation\Http\FormRequest;
use Cratespace\Sentinel\Http\Requests\Concerns\AuthorizesRequests;
use Cratespace\Sentinel\Http\Requests\Traits\InputValidationRules;

class PurchaseRequest extends FormRequest
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
        if ($this->user()->isCustomer()) {
            return $this->route('product')->available();
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesFor('order', [
            'payment_method' => [
                'required',
                'string',
                $this->container->make(PaymentMethodRule::class),
            ],
            'purchase_token' => [
                'required',
                'string',
                $this->container->make(PurchaseTokenRule::class),
            ],
            'product' => ['required', 'array'],
        ]);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        try {
            $this->merge([
                'customer' => $this->user()->customerId(),
                'product' => $this->route('product')->details(),
            ]);
        } catch (Throwable $e) {
            $this->failedAuthorization($e);
        }
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return ['customer' => 'Only valid customers can purchase from Cratespace'];
    }
}
