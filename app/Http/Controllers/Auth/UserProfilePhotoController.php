<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DeleteProfilePhotoRequest;
use App\Http\Responses\Auth\DeleteProfilePhotoResponse;

class UserProfilePhotoController extends Controller
{
    /**
     * Delete the current user's profile photo.
     *
     * @param \App\Http\App\Http\Requests\DeleteProfilePhotoRequest $request
     *
     * @return mixed
     */
    public function __invoke(DeleteProfilePhotoRequest $request)
    {
        $request->user()->deleteProfilePhoto();

        return DeleteProfilePhotoResponse::dispatch();
    }
}
