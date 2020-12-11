<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AuthorizesRequest;
use App\Http\Requests\Concerns\ValidatesPassword;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class DeleteUserRequest extends FormRequest
{
    use AuthorizesRequest;
    use ValidatesPassword;

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

    /*
     * Set the Validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function withValidator(): ValidatorContract
    {
        return $this->createPasswordValidator('password', 'deleteUser');
    }
}
