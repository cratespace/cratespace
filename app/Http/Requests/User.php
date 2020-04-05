<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\CheckAuthorization;
use App\Http\Requests\Traits\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
{
    use ValidationRules;
    use CheckAuthorization;

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
        return $this->userProfile();
    }
}
