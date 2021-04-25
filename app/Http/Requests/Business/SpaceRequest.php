<?php

namespace App\Http\Requests\Business;

use App\Http\Requests\Request;
use App\Products\Factories\SpaceFactory;

class SpaceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if ($this->route('space')) {
            return $this->isAllowed('manage', $this->space);
        }

        return $this->isAuthenticated('Business');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesFor('space');
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        $factory = $this->resolve(SpaceFactory::class);

        $this->user()->setResponsibility($factory->getProductInstance());
    }
}
