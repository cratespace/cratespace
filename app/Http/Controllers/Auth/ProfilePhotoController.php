<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProfilePhotoController extends Controller
{
    /**
     * Delete the current user's profile photo.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->user()->deleteProfilePhoto();

        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : back(303)->with('status', trans('Profile photo deleted'));
    }
}
