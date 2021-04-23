<?php

namespace App\Http\Requests\Business;

use Closure;
use App\Models\User;
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
        $this->merge(['email' => $this->business()->email]);
    }

    /**
     * Handle a passed validation attempt.
     *
     * @param \Closure
     *
     * @return void
     */
    public function tap(Closure $callback): void
    {
        call_user_func($callback, $this->user());
    }

    /**
     * Get the business user the invitation will be sent to.
     *
     * @return \App\Models\User
     */
    protected function business(): User
    {
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
