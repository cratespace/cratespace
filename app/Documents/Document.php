<?php

namespace App\Documents;

use Illuminate\Support\Arr;

abstract class Document
{
    /**
     * The directory where all documents are stored.
     *
     * @var string
     */
    protected $documentsDirectory = 'docs';

    /**
     * Create new Document manager instance.
     *
     * @param string|null $documentsDirectory
     *
     * @return void
     */
    public function __construct(?string $documentsDirectory = null)
    {
        if (! is_null($documentsDirectory)) {
            $this->documentsDirectory = $documentsDirectory;
        }
    }

    /**
     * Get the contents of the given document.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function get(string $name): ?string
    {
        $name = "{$name}.md";

        $localName = preg_replace('#(\.md)$#i', '.' . app()->getLocale() . '$1', $name);

        $file = Arr::first([
            resource_path('docs/' . $localName),
            resource_path('docs/' . $name),
        ], function ($path) {
            return file_exists($path);
        });

        return \file_get_contents($file);
    }
}
