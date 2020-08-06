<?php

namespace App\Auth;

use InvalidArgumentException;
use App\Models\User as UserModel;
use App\Auth\Relationships\Account;
use App\Auth\Relationships\Profile;
use App\Auth\Relationships\Business;
use App\Contracts\Auth\Responsibility;

class User extends UserModel
{
    /**
     * All responsibilities to perform when creating a new user account.
     *
     * @var array
     */
    protected $responsibilities = [
        Profile::class,
        Business::class,
        Account::class,
    ];

    /**
     * Create new user instance by following given responsibilities.
     *
     * @param array $data
     *
     * @return \App\Model\User
     */
    public function new(array $data)
    {
        try {
            return $this->performResponsibilities(new self(), $data);
        } catch (InvalidArgumentException $exception) {
            abort(500, $exception->getMessage());
        }
    }

    /**
     * Perfrom all registered reponsibilities.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return \App\Models\User
     */
    protected function performResponsibilities(UserModel $user, array $data): UserModel
    {
        foreach ($this->getResponsibilities() as $responsibility) {
            $responsibility = $this->resolveResponsibility($responsibility);

            $user = $responsibility->handle($user, $data);
        }

        return $user;
    }

    /**
     * Instantiate the responsibility class.
     *
     * @param string $responsibility
     *
     * @return \App\Contracts\Auth\Responsibility
     */
    protected function resolveResponsibility(string $responsibility): Responsibility
    {
        $responsibility = new $responsibility();

        if (!$responsibility instanceof Responsibility) {
            $responsibility = class_basename($responsibility);

            throw new InvalidArgumentException("Class {class_basename($responsibility)} does not adhere to the Responsibility interface");
        }

        return $responsibility;
    }

    /**
     * Get all registered reponsibilities.
     *
     * @return array
     */
    public function getResponsibilities(): array
    {
        return array_merge(
            $this->responsibilities,
            config('auth.responsibilities')
        );
    }
}
