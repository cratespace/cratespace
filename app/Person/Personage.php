<?php

namespace App\Person;

use App\Models\User;
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
        return $this->performResponsibilities(new User(), $data);
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
            $responsibilities = resolve($responsibilities);

            if ($responsibilities instanceof Responsibility) {
                $person = $responsibilities->create($person, $data);
            }
        }

        return $person;
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
