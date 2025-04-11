<?php

namespace App\Services\Notification;

use App\Enums;
use App\Models;
use App\Notifications;
use App\Repositories;
use App\Services\AbstractService;
use Notification;

class NotificationService extends AbstractService
{
    public function __construct(
        private Repositories\PushTokenRepository $push_token_repository,
        private Repositories\NotificationSettingRepository $notification_setting_repository
    ) {
        //
    }

    public function sendTestNotification(Models\User $user, Models\User $sender = null): bool
    {
        $notification = new Notifications\TestNotification($sender);

        $user->notify($notification);

        return true;
    }

    public function sendNewProductLiveNotification(Models\Product $product): bool
    {
        $notification_setting = $this->notification_setting_repository->getSettingForNotificationType(Enums\NotificationType::NEW_PRODUCT_LIVE);

        if ($notification_setting?->is_enabled) {
            $push_tokens = $this->push_token_repository->getAllUsersPushTokens();

            $notification = new Notifications\Product\NewProductLiveNotification($product);

            Notification::route('push', $push_tokens)->notify($notification);

            return true;
        }

        return false;
    }
}
