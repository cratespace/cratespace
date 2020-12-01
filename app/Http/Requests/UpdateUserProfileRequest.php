<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\ValidatesInput;
use App\Http\Requests\Traits\AuthorizesRequest;

class UpdateUserProfileRequest extends FormRequest
{
    use AuthorizesRequest;
    use ValidatesInput;

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
        return $this->getRulesFor('user_profile', [
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($this->user()->id),
            ],
        ]);
    }
}
