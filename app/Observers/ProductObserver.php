<?php

namespace App\Observers;

use App\Enums;
use App\Models;
use App\Services\Notification\NotificationService;

class ProductObserver
{
    public function created(Models\Product $product): void
    {
        if ($product->status === Enums\ProductStatus::LIVE) {
            $notification_service = NotificationService::make();
            $notification_service->sendNewProductLiveNotification($product);
        }
    }

    public function updated(Models\Product $product): void
    {
        if ($product->wasChanged('status') && $product->status === Enums\ProductStatus::LIVE) {
            $notification_service = NotificationService::make();
            $notification_service->sendNewProductLiveNotification($product);
        }
    }
}
