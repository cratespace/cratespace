<?php

namespace App\Documenters;

use Spatie\Sheets\Facades\Sheets;

abstract class Documents
{
    /**
     * Get all documents collection.
     *
     * @param  string $collection
     * @return \Spatie\Sheets\Repositories\FilesystemRepository
     */
    public static function get($collection)
    {
        return Sheets::collection($collection);
    }
}
