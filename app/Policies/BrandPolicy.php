<?php

namespace App\Policies;

use App\Models\Brand;
use App\Policies\Traits\ChecksAuthenticatableModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class BrandPolicy
{
    use ChecksAuthenticatableModel, HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Brand $brand): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }

    public function update(User $user, Brand $brand): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }

    public function delete(User $user, Brand $brand): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }
}
