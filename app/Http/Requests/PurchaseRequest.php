<?php

namespace App\Http\Requests;

use App\Rules\PaymentMethodRule;
use App\Rules\PurchaseTokenRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\InvalidCustomerException;
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
        return $this->isAllowed('purchase', $this->route('space'), false);
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
        ]);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        try {
            $this->merge(['customer' => $this->user()->customerId()]);
        } catch (InvalidCustomerException $e) {
            $this->failedAuthorization();
        }
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'customer' => 'Only customers can purchase from Cratespace.',
        ];
    }
}
