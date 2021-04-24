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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        $this->user()->setResponsibility(
            $this->resolve(SpaceFactory::class)->createProductInstance()
        );
    }
}
