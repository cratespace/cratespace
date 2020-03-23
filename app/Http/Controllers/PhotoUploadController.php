<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Image as ImageForm;

class PhotoUploadController extends Controller
{
    /**
     * Public image upload directory.
     *
     * @var string
     */
    protected $uploads = 'images';

    /**
     * Store a new user avatar.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ImageForm $request, $business = null)
    {
        $data = [
            'photo' => Storage::disk('s3')->url(
                $request->file('image')->store($this->uploads, 's3')
            )
        ];

        if (! is_null($business)) {
            user()->business()->update($data);
        } else {
            user()->update($data);
        }

        return response([], 204);
    }
}
