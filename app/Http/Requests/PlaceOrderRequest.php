<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\HasValidationRules;
use App\Http\Requests\Traits\AuthenticatesRequest;

class PlaceOrderRequest extends FormRequest
{
    use HasValidationRules;
    use AuthenticatesRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->resourceIsAvailable($this->space);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesFor('order');
    }
}
