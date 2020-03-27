<?php

namespace App\Person;

use App\Models\User;
use InvalidArgumentException;
use App\Contracts\Responsibility;

class Personage
{
    /**
     * All following responsibillities to perform.
     *
     * @var array
     */
    protected $responsibilities = [
        \App\Person\Profile::class,
        \App\Person\Business::class,
        \App\Person\Account::class,
    ];

    /**
     * Create new user instance by following given responsibilities.
     *
     * @param  array  $data
     * @return \App\Model\User
     */
    public function new(array $data)
    {
        try {
            return $this->performResponsibilities(new User(), $data);
        } catch (Exception $e) {
            abort(config('messages.registration'));
        }
    }

    /**
     * Perfrom all registered reponsibilities.
     *
     * @param  \App\Models\User $person
     * @param  array  $data
     * @return void
     */
    protected function performResponsibilities(User $person, array $data)
    {
        foreach ($this->getResponsibilities() as $responsibilities) {
            $responsibilities = $this->resolveResponsibility($responsibilities);

            if (! $responsibilities instanceof Responsibility) {
                throw new InvalidArgumentException();
            }

            $person = $responsibilities->handle($person, $data);
        }

        return $person;
    }

    /**
     * Instanciate the responsibility class.
     *
     * @param  string $responsibilities
     * @return \App\Contracts\Responsibility
     */
    protected function resolveResponsibility(string $responsibilities)
    {
        return new $responsibilities();
    }

    /**
     * Get all registered reponsibilities.
     *
     * @param  \App\Models\User $person
     * @param  array  $data
     * @return void
     */
    protected function getResponsibilities()
    {
        return $this->responsibilities;
    }
}
