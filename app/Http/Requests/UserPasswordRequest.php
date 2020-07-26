<?php

namespace App\Http\Requests;

use App\Rules\CurrentPasswordCheck;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AuthorizesRequest;
use App\Http\Requests\Traits\HasValidationRules;

class UserPasswordRequest extends FormRequest
{
    use AuthorizesRequest;
    use HasValidationRules;

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
        return $this->getRulesFor('user-password', [
            'old_password' => [
                'required', 'string', 'min:8', new CurrentPasswordCheck(),
            ],
        ]);
    }
}
