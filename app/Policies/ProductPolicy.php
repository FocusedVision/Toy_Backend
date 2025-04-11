<?php

namespace App\Policies;

use App\Models\Product;
use App\Policies\Traits\ChecksAuthenticatableModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class ProductPolicy
{
    use ChecksAuthenticatableModel, HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Product $product): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }

    public function update(User $user, Product $product): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }

    public function delete(User $user, Product $product): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }
}
