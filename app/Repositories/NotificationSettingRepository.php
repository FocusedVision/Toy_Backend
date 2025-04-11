<?php

namespace App\Repositories;

use App\Enums;
use App\Models;

class NotificationSettingRepository
{
    public function getSettingForNotificationType(Enums\NotificationType $notification_type): ?Models\NotificationSetting
    {
        return Models\NotificationSetting::where('notification_type', $notification_type)->first();
    }
}
