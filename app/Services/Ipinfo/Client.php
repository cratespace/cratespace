<?php

namespace App\Services\Ipinfo;

use ipinfo\ipinfo\Details;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use ipinfo\ipinfo\cache\DefaultCache;
use ipinfo\ipinfo\IPinfo as IPinfoClient;
use App\Contracts\Services\Client as ClientContract;

class Client implements ClientContract
{
    /**
     * The HTTP request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The Ipinfo client instance.
     *
     * @var \ipinfo\ipinfo\IPinfo
     */
    protected $ip;

    /**
     * Maximum cache memory size limit.
     */
    const CACHE_MAXSIZE = 4096;

    /**
     * Cache expiration time.
     */
    const CACHE_TTL = 60 * 24;

    /**
     * Create new instance of Ipinfo client.
     *
     * @param \Illuminate\Http\Request   $request
     * @param \ipinfo\ipinfo\IPinfo|null $ip
     */
    public function __construct(Request $request, ?IPinfoClient $ip = null)
    {
        $this->request = $request;
        $this->ip = $ip;
    }

    /**
     * Create Stripe client instance.
     *
     * @param array[] $config
     *
     * @return mixed
     */
    public function make(array $config = [])
    {
        $this->defaultFilter();

        if (is_null($this->ip)) {
            $this->ip = new IPinfoClient(
                $config['access_token'],
                $this->options($config)
            );
        }

        return $this->ip;
    }

    /**
     * Get formatted details for an IP address.
     *
     * @param string|null $ipAddress IP address to look up
     *
     * @return \ipinfo\ipinfo\Details formatted IPinfo data
     *
     * @throws \ipinfo\ipinfo\IPinfoException
     */
    public function getDetails(?string $ipAddress = null): Details
    {
        return $this->ip->getDetails($ipAddress ?? $this->request->ip());
    }

    /**
     * Get the default Stripe API options.
     *
     * @param array[] $options
     *
     * @return array
     */
    public function options(array $options = []): array
    {
        return array_merge([
            'cache' => new DefaultCache(
                self::CACHE_MAXSIZE, self::CACHE_TTL
            ),
        ], array_filter($options, function ($key) {
            return $key !== 'access_token';
        }, \ARRAY_FILTER_USE_KEY));
    }

    /**
     * Should IP lookup be skipped.
     *
     * @return bool
     */
    public function defaultFilter(): bool
    {
        $userAgent = $this->request->header('user-agent');

        if ($userAgent) {
            $lowerUserAgent = strtolower($userAgent);
            $isSpider = strpos($lowerUserAgent, 'spider') !== false;
            $isBot = strpos($lowerUserAgent, 'bot') !== false;

            return $isSpider || $isBot;
        }

        return false;
    }

    /**
     * Dynamically get Ipinfo client services.
     *
     * @param mixed $name
     * @param mixed $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->getDetails()->{Str::snake($name)};
    }
}
