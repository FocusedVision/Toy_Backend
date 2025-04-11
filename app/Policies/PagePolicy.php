<?php

namespace App\Policies;

use App\Models\Page;
use App\Policies\Traits\ChecksAuthenticatableModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class PagePolicy
{
    use ChecksAuthenticatableModel, HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Page $page): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }

    public function update(User $user, Page $page): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }

    public function delete(User $user, Page $page): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }
}
