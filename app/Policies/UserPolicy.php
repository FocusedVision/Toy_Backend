<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\Traits\ChecksAuthenticatableModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserPolicy
{
    use ChecksAuthenticatableModel, HandlesAuthorization;

    private function isItself(Authenticatable $authenticatable, User $user): bool
    {
        return $authenticatable->id === $user->id;
    }

    public function viewAny(Authenticatable $authenticatable): bool
    {
        return true;
    }

    public function view(Authenticatable $authenticatable, User $user): bool
    {
        return true;
    }

    public function create(Authenticatable $authenticatable): bool
    {
        return $this->isAdmin($authenticatable) && $authenticatable->isEditor();
    }

    public function update(Authenticatable $authenticatable, User $user): bool
    {
        return ($this->isUser($authenticatable) && $this->isItself($authenticatable, $user)) || ($this->isAdmin($authenticatable) && $authenticatable->isEditor());
    }

    public function delete(Authenticatable $authenticatable, User $user): bool
    {
        return $this->isAdmin($authenticatable) && $authenticatable->isEditor();
    }
}
