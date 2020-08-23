<?php

namespace App\Inspections;

class Spam
{
    /**
     * All registered inspections.
     *
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
    ];

    /**
     * Detect spam.
     *
     * @param string $body
     *
     * @return bool
     */
    public function detect(string $body): bool
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
