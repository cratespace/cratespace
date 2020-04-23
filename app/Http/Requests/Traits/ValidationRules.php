<?php

namespace App\Http\Requests\Traits;

use App\Models\User;
<<<<<<< HEAD
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use Illuminate\Validation\Rule;
use App\Rules\CurrentPasswordCheck;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
=======
use App\Rules\CurrentPasswordCheck;
use Illuminate\Validation\Rule;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951

trait ValidationRules
{
    /**
     * Get space input validation rules.
     *
     * @return array
     */
    protected function space()
    {
        return config('validation.space');
    }

    /**
     * Get order input validation rules.
     *
     * @return array
     */
    protected function order()
    {
<<<<<<< HEAD
        if (request('payment_type') === 'credit_card') {
=======
        if ('credit_card' === request('payment_type')) {
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
            return array_merge(
                config('validation.order'),
                $this->creditcard()
            );
        }

        return config('validation.order');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function creditcard()
    {
        return [
            'name_on_card' => ['required', 'string', 'max:255'],
            'card_number' => ['required', new CardNumber()],
            'expiration_year' => ['required', new CardExpirationYear($this->get('expiration_month'))],
            'expiration_month' => ['required', new CardExpirationMonth($this->get('expiration_year'))],
            'cvc' => ['required', new CardCvc($this->get('card_number'))],
        ];
    }

    /**
     * Get client message input validation rules.
     *
     * @return array
     */
    protected function message()
    {
        return config('validation.message');
    }

    /**
     * Get user profile rules.
     *
     * @return array
     */
    protected function userProfile()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'business' => [!request('business') ? 'nullable' : 'required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique((new User())->getTable())->ignore(auth()->id()),
            ],
            'phone' => ['nullable', 'integer', 'min:9'],
        ];
    }

    /**
     * Get user password rules.
     *
     * @return array
     */
    protected function userPassword()
    {
        return [
            'old_password' => ['required', 'string', 'min:8', new CurrentPasswordCheck()],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:old_password'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * Get user business rules.
     *
     * @return array
     */
    protected function business()
    {
        return config('validation.business');
    }

    /**
     * Get address input validation rules.
     *
     * @return array
     */
    protected function address()
    {
        return config('validation.address');
    }

    /**
     * Get thread input validation rules.
     *
     * @return array
     */
    protected function thread()
    {
        return config('validation.thread');
    }
}
