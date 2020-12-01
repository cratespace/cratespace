<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserProfilePhotoController extends Controller
{
    /**
     * Delete the current user's profile photo.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Request $request): Response
    {
        $this->authorize('update', $request->user());

        $request->user()->deleteProfilePhoto();

        return $request->wantsJson()
            ? response()->json('', 204)
            : back(303)->with('status', 'profile-photo-deleted');
    }
}
