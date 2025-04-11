<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    public function label()
    {
        return __('Dashboard');
    }

    public function cards()
    {
        return [
            Metrics\Value\NewUsersValue::make()->width('1/3')->defaultRange('TODAY'),
            Metrics\Trend\UsersPerDayTrend::make()->width('1/3')->defaultRange(7),
            Metrics\Progress\NewUsersProgress::make()->width('1/3'),

            Metrics\Product\Trend\OpeningsTrend::make()->width('1/3'),
            Metrics\Product\Trend\ModelLoadingsTrend::make()->width('1/3'),
            Metrics\Product\Trend\AnimationPlaysTrend::make()->width('1/3'),

            Metrics\Product\Trend\FullAnimationPlaysTrend::make()->width('1/3'),
            Metrics\Product\Trend\WishlistAddingTrend::make()->width('1/3'),
            Metrics\Product\Trend\LikesTrend::make()->width('1/3'),

            Metrics\Product\Value\AverageOpenTimeValue::make()->width('1/2'),
            Metrics\Product\Value\MaxOpenTimeValue::make()->width('1/2'),
        ];
    }
}
