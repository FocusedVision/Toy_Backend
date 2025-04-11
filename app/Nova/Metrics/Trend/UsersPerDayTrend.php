<?php

namespace App\Nova\Metrics\Trend;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class UsersPerDayTrend extends Trend
{
    public function name()
    {
        return __('Users Per Day');
    }

    public function calculate(NovaRequest $request)
    {
        return $this->countByDays($request, User::class);
    }

    public function ranges()
    {
        return [
            7 => __('1 Week'),
            14 => __('2 Weeks'),
            30 => __('1 Month'),
            60 => __('2 Months'),
            90 => __('3 Months'),
        ];
    }

    public function cacheFor()
    {
        return now()->addMinutes(config('app.env') == 'production' ? 5 : 1);
    }

    public function uriKey()
    {
        return 'users-per-day-trend';
    }
}
