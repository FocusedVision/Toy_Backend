<?php

namespace App\Policies;

use App\Models\NotificationSetting;
use App\Policies\Traits\ChecksAuthenticatableModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class NotificationSettingPolicy
{
    use ChecksAuthenticatableModel, HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, NotificationSetting $notification_setting): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, NotificationSetting $notification_setting): bool
    {
        return $this->isAdmin($user) && $user->isEditor();
    }

    public function delete(User $user, NotificationSetting $notification_setting): bool
    {
        return false;
    }
}
