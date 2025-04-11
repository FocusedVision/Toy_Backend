<?php

namespace App\Policies;

use App\Models\Admin;
use App\Policies\Traits\ChecksAuthenticatableModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class AdminPolicy
{
    use ChecksAuthenticatableModel, HandlesAuthorization;

    private function isItself(User $user, Admin $admin): bool
    {
        return $user->id === $admin->id;
    }

    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, Admin $admin): bool
    {
        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) && $user->isModerator();
    }

    public function update(User $user, Admin $admin): bool
    {
        return $this->isAdmin($user) && ($user->isModerator() || $this->isItself($user, $admin));
    }

    public function delete(User $user, Admin $admin): bool
    {
        return $this->isAdmin($user) && $user->isModerator();
    }
}
