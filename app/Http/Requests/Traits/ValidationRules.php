<?php

namespace App\Http\Requests\Traits;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Rules\CurrentPasswordCheck;

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
        return config('validation.order');
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
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique((new User())->getTable())->ignore(auth()->id())
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
}
