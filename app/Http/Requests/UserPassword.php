<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\ValidationRules;
use App\Http\Requests\Traits\CheckAuthorization;

class UserPassword extends FormRequest
{
    use ValidationRules, CheckAuthorization;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->resourceBelongsToUser($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->userPassword();
    }
}