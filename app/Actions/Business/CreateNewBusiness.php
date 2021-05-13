<?php

namespace App\Actions\Business;

use App\Models\Business;
use App\Exceptions\BusinessAlreadyCreated;
use Cratespace\Sentinel\Contracts\Actions\CreatesNewResource;

class CreateNewBusiness implements CreatesNewResource
{
    /**
     * Create a new resource type.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return with($data['user'], function ($user) use ($data) {
            if ($user->isBusiness()) {
                throw BusinessAlreadyCreated::exists($user->businessId());
            }

            Business::create(static::options([
                'user_id' => $user->id,
                'name' => $data['business'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'registration_number' => $data['registration_number'],
                'mcc' => $data['mcc'] ?? null,
            ]));

            $user->assignRole('Business');

            return $user;
        });
    }

    /**
     * Default options to include when creating a new business profile.
     *
     * @param array $data
     *
     * @return array
     */
    public static function options(array $data = []): array
    {
        return array_merge([
            'type' => 'standard',
            'business_type' => 'company',
        ], $data);
    }
}
