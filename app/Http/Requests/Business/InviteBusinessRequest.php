<?php

namespace App\Http\Requests\Business;

use App\Models\Invitation;
use Cratespace\Sentinel\Http\Requests\Request;

class InviteBusinessRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if ($this->business()->isBusiness()) {
            return $this->isAllowed('create', new Invitation(), false);
        }

        return false;
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

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['email' => $this->business('email')]);

        if ($this->user()->isAdmin()) {
            $this->user()->setResponsibility($this->business());
        }
    }

    /**
     * Get the business user the invitation will be sent to.
     *
     * @param string|null $attribute
     *
     * @return mixed
     */
    protected function business(?string $attribute = null)
    {
        if (! is_null($attribute)) {
            return $this->route('user')->{$attribute};
        }

        return $this->route('user');
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return ['email' => __('This user has already been invited.')];
    }
}
