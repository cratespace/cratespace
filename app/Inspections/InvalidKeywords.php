<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    /**
     * All registered invalid keywords.
     *
     * @var array
     */
    protected $keywords = [
        'yahoo customer support',
    ];

    /**
     * Detect spam.
     *
     * @param string $body
     *
     * @return void
     *
     * @throws \Exception
     */
    public function detect(string $body): void
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('Your reply contains spam.');
            }
        }
    }
}
