<?php

namespace App\Validations;

use Illuminate\Contracts\Config\Repository;

abstract class Validation
{
    /**
     * All registered rules.
     *
     * @var array
     */
    protected $rules;

    /**
     * Create new validator instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->rules = $config['validation'];
    }

    /**
     * Get relevant validation rules for given resource.
     *
     * @param string $resource
     * @param array  $additionalRules
     *
     * @return array
     */
    public function getRulesFor(string $resource, $additionalRules = []): array
    {
        if ($additionalRules !== []) {
            return array_merge($this->rules[$resource], $additionalRules);
        }

        return $this->rules[$resource];
    }
}
