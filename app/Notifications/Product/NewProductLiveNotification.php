<?php

namespace App\Notifications\Product;

use App\Enums;
use App\Models;
use App\Notifications\AbstractNotification;
use App\Notifications\Channels;
use App\Notifications\Contracts;
use App\Notifications\Messages;

class NewProductLiveNotification extends AbstractNotification implements Contracts\PushNotificationContract
{
    public function __construct(
        private Models\Product $product
    ) {
        //
    }

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
            ->title(__('New toy available!'))
            ->body(__('Click to view it'))
            ->data('type', Enums\NotificationType::NEW_PRODUCT_LIVE)
            ->data('product_id', $this->product->id);
    }
}
