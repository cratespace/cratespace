<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AuthorizesRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    use AuthorizesRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->resourceBelongsToUser($this->order);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['status' => 'required', 'string'];
    }
}