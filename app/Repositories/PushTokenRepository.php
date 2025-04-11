<?php

namespace App\Repositories;

use App\Models;
use Illuminate\Support\Collection;

class PushTokenRepository
{
    public function upsert(array $data): void
    {
        Models\PushToken::upsert($data, [
            'token',
        ], [
            'user_id',
            'failures_count',
        ]);
    }

    public function getAllUsersPushTokens(): Collection
    {
        return Models\User::with('pushTokens')->get()->pluck('pushTokens')->flatten();
    }

    public function deleteArray(array $tokens): void
    {
        Models\PushToken::whereIn('token', $tokens)->delete();
    }

    public function deleteUserPushTokens(Models\User $user): void
    {
        $user->pushTokens()->delete();
    }
}
