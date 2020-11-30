<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AuthorizesRequest;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class OtherBrowserSessionsRequest extends FormRequest
{
    use AuthorizesRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->authenticated();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password' => [__('This password does not match our records.')],
        ];
    }

    /**
     * Set the Validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function withValidator(): ValidatorContract
    {
        $validator = Validator::make($this->all(), $this->rules());

        $validator->after(function ($validator) {
            if (!Hash::check($this->input('current_password'), $this->user()->password)) {
                $validator->errors()->add(
                    'current_password',
                    $this->messages()['current_password']
                );
            }
        })->validateWithBag('logoutOtherBrowserSessions');

        return $validator;
    }
}
