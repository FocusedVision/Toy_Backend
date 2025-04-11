<?php

namespace App\Notifications;

use App\Enums;

class TestNotification extends AbstractNotification implements Contracts\PushNotificationContract
{
    public function via(mixed $notifiable): array
    {
        return [
            Channels\PushChannel::class,
        ];
    }

    public function viaQueues(): array
    {
        return [
            Channels\PushChannel::class => 'push',
        ];
    }

    public function toPush(mixed $notifiable): Messages\PushMessage
    {
        return Messages\PushMessage::make()
            ->title(__('This is a title'))
            ->body(__('This is a body'))
            ->data('type', Enums\NotificationType::TEST);
    }
}
