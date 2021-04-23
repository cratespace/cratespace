<?php

namespace Tests\Concerns;

trait InteractsWithFiles
{
    /**
     * Check for given files' existance and delete if found.
     *
     * @param string $file
     *
     * @return void
     */
    protected function deleteFile(string $file): void
    {
        if (file_exists($file)) {
            \unlink($file);
        }
    }
}
