<?php

namespace App\Http\Requests\Auth;

use App\Auth\Config\Auth;
use App\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->isGuest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $username = Auth::username();

        return $this->getRulesFor('login', [
            $username => [
                'required',
                'string',
                $username === 'email' ? 'email' : null,
            ],
        ]);
    }
}