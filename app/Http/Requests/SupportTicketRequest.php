<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\AuthorizesRequest;
use App\Http\Requests\Traits\HasValidationRules;

class SupportTicketRequest extends FormRequest
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
        if ($this->has('status')) {
            return Gate::allows('viewAny', $this->ticket);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->has('status')) {
            return ['status' => Rule::in(config('defaults.tickets.statuses'))];
        }

        return $this->getRulesFor('ticket');
    }
}
