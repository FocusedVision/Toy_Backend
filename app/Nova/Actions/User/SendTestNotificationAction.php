<?php

namespace App\Nova\Actions\User;

use App\Models;
use App\Services;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class SendTestNotificationAction extends Action
{
    use InteractsWithQueue, Queueable;

    public function name()
    {
        return __('Send test notification');
    }

    public function handle(ActionFields $fields, Collection $models)
    {
        $notification_service = Services\Notification\NotificationService::make();

        foreach ($models as $model) {
            if ($model instanceof Models\User) {
                $notification_service->sendTestNotification($model);
            }
        }

        return Action::message(__('Notification sent'));
    }
}
