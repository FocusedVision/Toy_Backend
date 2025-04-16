<?php

namespace App\Nova\Actions\Product;

use App\Models;
use App\Repositories;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class MakeLiveAction extends Action
{
    use InteractsWithQueue, Queueable;

    public function name()
    {
        return __('Make live');
    }

    public function handle(ActionFields $fields, Collection $models)
    {
        $product_repository = new Repositories\ProductRepository();
        $notification_service = new \App\Services\Notification\NotificationService(
            app(\App\Repositories\PushTokenRepository::class),
            app(\App\Repositories\NotificationSettingRepository::class)
        );

        foreach ($models as $model) {
            if ($model instanceof Models\Product) {
                $product_repository->makeLive($model);
                $notification_service->sendNewProductLiveNotification($model);
            }
        }
    }
}
