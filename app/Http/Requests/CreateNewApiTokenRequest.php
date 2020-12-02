<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AuthorizesRequest;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class CreateNewApiTokenRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
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
        $validator = Validator::make($this->all(), $this->rules());

        $validator->validateWithBag('createApiToken');

        return $validator;
    }
}
