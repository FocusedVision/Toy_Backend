<?php

namespace App\Nova;

use App\Enums;
use App\Models;
use App\Nova\Fields as CustomFields;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;

class NotificationSetting extends Resource
{
    public static $model = Models\NotificationSetting::class;

    public static $search = [
        'id', 'type',
    ];

    public static function group()
    {
        return __('Notifications');
    }

    public static function label()
    {
        return __('Settings');
    }

    public static function singularLabel()
    {
        return __('Setting');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Fields\ID::make()->sortable(),

            CustomFields\Enum::make(__('Notification type'), 'notification_type', Enums\NotificationType::class)
                ->rules('required')
                ->exceptOnForms(),

            Fields\Boolean::make(__('Is enabled'), 'is_enabled')
                ->rules('required'),

            ...$this->getTimestampsFields(),
        ];
    }
}
