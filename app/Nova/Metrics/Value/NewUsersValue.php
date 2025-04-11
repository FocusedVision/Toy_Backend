<?php

namespace App\Nova\Metrics\Value;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class NewUsersValue extends Value
{
    public function name()
    {
        return __('New users');
    }

    public function calculate(NovaRequest $request)
    {
        return $this->count($request, User::class);
    }

    public function ranges()
    {
        return [
            7 => __('1 Week'),
            14 => __('2 Weeks'),
            30 => __('1 Month'),
            60 => __('2 Months'),
            365 => __('1 Year'),
            'TODAY' => __('Today'),
            'MTD' => __('Month To Date'),
            'QTD' => __('Quarter To Date'),
            'YTD' => __('Year To Date'),
        ];
    }

    public function cacheFor()
    {
        return now()->addMinutes(config('app.env') == 'production' ? 5 : 1);
    }

    public function uriKey()
    {
        return 'new-users-value';
    }
}
