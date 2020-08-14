<?php

namespace App\Auth;

use Error;
use InvalidArgumentException;
use App\Models\User as UserModel;
use Illuminate\Pipeline\Pipeline;
use App\Auth\Relationships\Account;
use App\Auth\Relationships\Profile;
use App\Auth\Relationships\Business;

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
            return $this->performResponsibilities($data);
        } catch (InvalidArgumentException $e) {
            abort(503, $e->getMessage());
        }
    }

    /**
     * Perform all registered responsibilities.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return \App\Models\User
     *
     * @throws \InvalidArgumentException
     */
    protected function performResponsibilities(array $data): UserModel
    {
        $data['user'] = $this;

        try {
            return (new Pipeline(app()))->send($data)
                ->through($this->getResponsibilities())
                ->via('handle')
                ->then(function ($data) {
                    return $data['user'];
                });
        } catch (Error $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Get all registered responsibilities.
     *
     * @return array
     */
    public function getResponsibilities(): array
    {
        return array_merge($this->responsibilities, config('auth.responsibilities'));
    }
}
