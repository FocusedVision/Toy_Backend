<?php

namespace App\Policies\Traits;

use App\Models;
use Illuminate\Foundation\Auth\User;

trait ChecksAuthenticatableModel
{
    private function isAdmin(User $user): bool
    {
        return $user instanceof Models\Admin;
    }

    private function isUser(User $user): bool
    {
        return $user instanceof Models\User;
    }
}
