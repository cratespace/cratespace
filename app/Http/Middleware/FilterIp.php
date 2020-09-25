<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Services\IpService;

class FilterIp
{
    /**
     * Create new instance of IP service.
     *
     * @param \App\Http\Services\IpService $ip
     */
    public function __construct(IpService $ip)
    {
        $this->ip = $ip;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->isWhiteListed($this->ip->get())) {
            return $next($request);
        }

        abort(403);
    }

    /**
     * Determine if the IP is allowed to pass through.
     *
     * @param string $ip
     *
     * @return bool
     */
    protected function isWhiteListed(string $ip): bool
    {
        return in_array($ip, $this->ipWhiteList());
    }

    /**
     * Get list of allowable IP.
     *
     * @return array
     */
    protected function ipWhiteList(): array
    {
        return [];
    }
}
