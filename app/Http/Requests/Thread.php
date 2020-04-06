<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\CheckAuthorization;
use App\Http\Requests\Traits\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class Thread extends FormRequest
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
        return $this->authenticated();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->thread();
    }
}
