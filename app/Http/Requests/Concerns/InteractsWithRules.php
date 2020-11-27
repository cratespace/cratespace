<?php

namespace App\Http\Requests\Concerns;

trait InteractsWithRules
{
    /**
     * Get validation rules of given entity.
     *
     * @param string $rulesOf
     * @param array  $additionalRules
     *
     * @return array
     */
    public function getRules(string $rulesOf, array $additionalRules = []): array
    {
        return array_merge(config('rules.' . $rulesOf), $additionalRules);
    }
}
