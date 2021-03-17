<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Cratespace\Sentinel\Http\Requests\Concerns\AuthorizesRequests;

class OrderRequest extends FormRequest
{
    use AuthorizesRequests;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isAllowed('delete', $this->route('order'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
