<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserDetailsRequest;

class CurrentUserController extends Controller
{
    /**
     * Get details about user making the request.
     *
     * @param \App\Http\Requests\UserDetailsRequest $request
     * @param string|null                           $attribute
     *
     * @return mixed
     */
    public function __invoke(UserDetailsRequest $request, ?string $attribute = null)
    {
        if (is_null($attribute)) {
            return $request->user();
        }

        return $request->user()->{$attribute};
    }
}
