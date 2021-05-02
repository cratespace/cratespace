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

            Business::create([
                'user_id' => $user->id,
                'type' => 'standard',
                'name' => $data['business'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'registration_number' => $data['registration_number'],
                'business_type' => 'company',
                'business_profile' => [
                    'name' => $data['business'],
                    'mcc' => $data['mcc'] ?? null,
                    'support_phone' => $data['phone'],
                    'support_email' => $data['email'],
                    'url' => $data['url'] ?? null,
                ],
            ]);

            $user->assignRole('Business');

            return $user;
        });
    }
}
