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

    public function sendNewProductLiveNotification(Models\Product $product): bool
    {
        $notification_setting = $this->notification_setting_repository->getSettingForNotificationType(Enums\NotificationType::NEW_PRODUCT_LIVE);
        
        \Log::info('Attempting to send new product notification', [
            'product_id' => $product->id,
            'settings_enabled' => $notification_setting?->is_enabled,
            'product_name' => $product->name, // Add product name
            'product_status' => $product->status, // Add product status
        ]);

        if ($notification_setting?->is_enabled) {
            $push_tokens = $this->push_token_repository->getAllUsersPushTokens();
            
            \Log::info('Push tokens found', [
                'count' => count($push_tokens),
                'tokens' => $push_tokens->pluck('token')->toArray(), // Log actual tokens
                'user_ids' => $push_tokens->pluck('user_id')->toArray(), // Log user IDs
            ]);

            $notification = new Notifications\Product\NewProductLiveNotification($product);

            try {
                Notification::route('push', $push_tokens)->notify($notification);
                \Log::info('Notification sent successfully', [
                    'notification_class' => get_class($notification),
                    'channels' => $notification->via(null),
                ]);
                return true;
            } catch (\Exception $e) {
                \Log::error('Failed to send notification', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return false;
            }
        }

        \Log::info('Notification not sent - settings disabled');
        return false;
    }
}
