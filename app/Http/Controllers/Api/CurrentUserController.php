<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserDetailsRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function __invoke(UserDetailsRequest $request, ?string $attribute = null): JsonResponse
    {
        if (is_null($attribute)) {
            return response()->json($request->user());
        }

        return response()->json($request->user()->{$attribute});
    }
}
