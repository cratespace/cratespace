<?php

namespace App\Http\Services\Ip;

use App\Http\Services\Service;
use Stevebauman\Location\Facades\Location;

class Retriever extends Service
{
    /**
     * Index of sources to get client IP address from.
     *
     * @var array
     */
    protected $sources = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];

    /**
     * Currently identified IP address.
     *
     * @var sttring
     */
    protected $adddress;

    /**
     * Get client IP address from valid source.
     *
     * @return string
     */
    public function get()
    {
        foreach ($this->sources as $source) {
            $this->address = $_SERVER[$source] ?? request()->ip();
        }

        if (! (new Validator())->isPrivate($this->address)) {
            return $this->address;
        }

        return null;
    }
}
