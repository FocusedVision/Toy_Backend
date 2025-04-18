<?php

namespace App\Policies;

use App\Models\Tag;
use App\Policies\Traits\ChecksAuthenticatableModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class TagPolicy
{
    use ChecksAuthenticatableModel, HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Tag $tag): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }

    public function update(User $user, Tag $tag): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }

    public function delete(User $user, Tag $tag): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }
}
