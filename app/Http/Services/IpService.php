<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Services\Validators\IpValidator;

class IpService extends Service
{
    /**
     * Index of sources to get client IP address from.
     *
     * @var array
     */
    protected $sources = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR',
    ];

    /**
     * Instance of HTTP request.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create new instance of IP retrieval service.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return collect($this->sources)
            ->map(function ($source) {
                return $_SERVER[$source] ?? null;
            })
            ->merge([$this->request->ip])
            ->filter(function ($ip) {
                if ($ip !== null) {
                    return $this->validateIp($ip);
                }
            })
            ->unique()
            ->first();
    }

    /**
     * Retrieve IP of user.
     *
     * @return string
     */
    public function getIp(): string
    {
        return $this->get();
    }

    /**
     * Validate given IP address.
     *
     * @param string $ip
     *
     * @return bool
     */
    protected function validateIp(string $ip): bool
    {
        return $this->getValidator()->validate($ip);
    }

    /**
     * Get IP address validators.
     *
     * @return App\Http\Services\Validators\IpValidator
     */
    protected function getValidator(): IpValidator
    {
        return new IpValidator();
    }
}
