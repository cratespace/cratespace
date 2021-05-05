<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FormatMonetaryValues
{
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
        collect($this->getKeyWords())
            ->each(function (string $field) use ($request) {
                if ($this->hasValidField($field, $request)) {
                    $request->merge([
                        $field => $this->formatAmount($request->{$field}),
                    ]);
                }
            });

        return $next($request);
    }

    /**
     * Convert monetary amount into centes.
     *
     * @param string $amount
     *
     * @return int
     */
    protected function formatAmount(string $amount): int
    {
        return (int) ($amount * 100);
    }

    /**
     * Determine if the request.
     *
     * @param string                   $field
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function hasValidField(string $field, Request $request): bool
    {
        return array_key_exists($field, $request->all()) && is_numeric($request->{$field});
    }

    /**
     * List of key words to convert to cents.
     *
     * @return array
     */
    protected function getKeyWords(): array
    {
        return config('billing.key_words', []);
    }
}
