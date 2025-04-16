<?php

namespace App\Observers;

use App\Models\User;
use App\Models\NotificationSetting;
use App\Enums\NotificationType;

class UserObserver
{
    public function creating(User $user): void
    {
        $user->generateDeviceId();
    }

    public function created(User $user): void
    {
        NotificationSetting::create([
            'notification_type' => NotificationType::NEW_PRODUCT_LIVE,
            'user_id' => $user->id,
            'is_enabled' => true
        ]);
    }
}

