<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\ValidatesInput;
use App\Http\Requests\Traits\AuthorizesRequest;
use App\Http\Requests\Concerns\ValidatesPassword;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class UpdatePasswordRequest extends FormRequest
{
    use AuthorizesRequest;
    use ValidatesPassword;
    use ValidatesInput;

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
        return $this->getRulesFor('update_password');
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'current_password' => __('The provided password does not match your current password.'),
        ];
    }

    /*
     * Set the Validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function withValidator(): ValidatorContract
    {
        return $this->createPasswordValidator('current_password', 'updatePassword');
    }
}
