<?php

namespace App\Repositories;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class UserRepository
{
    public function firstOrCreateByDeviceId(string $device_id = null): User
    {
        if ($device_id === null) {
            return User::create();
        }

        return User::firstOrCreate([
            'device_id' => $device_id,
        ]);
    }

    public function createAccessToken(User $user): NewAccessToken
    {
        $token = $user->createToken('default');

        return $token;
    }

    public function update(User $user, array $data): User
    {
        $user->fill($data);

        if ($user->isDirty()) {
            $user->save();
        }

        return $user;
    }
}
