<?php

namespace App\Http\Requests\Customer;

use App\Models\User;
use App\Rules\PaymentTokenRule;
use Cratespace\Sentinel\Http\Requests\Request;

class OrderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->isAuthenticated();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesFor('order', [
            'payment_token' => [
                'required',
                'string',
                $this->resolve(PaymentTokenRule::class),
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
        $this->merge(['customer' => $this->customer()]);
    }

    /**
     * Guess the customer responsible for this request.
     *
     * @return string
     */
    public function customer(): string
    {
        if ($this->has('customer')) {
            return $this->customer;
        }

        $user = User::whereName($this->name)->first();

        if (! is_null($user)) {
            return $user->customerId();
        }

        return $this->user()->customerId();
    }
}
