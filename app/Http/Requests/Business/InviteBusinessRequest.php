<?php

namespace App\Http\Requests\Business;

use App\Models\Invitation;
use App\Http\Requests\Request;

class InviteBusinessRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (! $this->route('user')->hasRole('Business')) {
            return false;
        }

        return $this->isAllowed('create', new Invitation(), false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesFor('invitation');
    }
}
