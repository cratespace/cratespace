<?php

namespace App\Http\Requests;

use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AuthorizesRequest;
use App\Http\Requests\Traits\HasValidationRules;

class PlaceOrderRequest extends FormRequest
{
    use HasValidationRules;
    use AuthorizesRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->resourceIsAvailable($this->space);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesFor('order', app()->runningUnitTests() ? [] : [
            'name_on_card' => ['required', 'string', 'max:255'],
            'number' => ['required', new CardNumber()],
            'exp_year' => ['required', new CardExpirationYear($this->get('exp_month'))],
            'exp_month' => ['required', new CardExpirationMonth($this->get('exp_year'))],
            'cvc' => ['required', new CardCvc($this->get('number'))],
        ]);
    }

    /**
     * Get card details provided by request.
     *
     * @return array
     */
    public function getCardDetails(): array
    {
        return [
            'number' => $this->number,
            'exp_month' => $this->exp_month,
            'exp_year' => $this->exp_year,
            'cvc' => $this->cvc,
        ];
    }
}
