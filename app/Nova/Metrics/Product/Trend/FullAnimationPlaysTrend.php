<?php

namespace App\Nova\Metrics\Product\Trend;

use App\Models;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class FullAnimationPlaysTrend extends Trend
{
    public function name()
    {
        return __('Animation completes');
    }

    public function calculate(NovaRequest $request)
    {
        if ($request->resourceId !== null) {
            $product = Models\Product::find($request->resourceId);

            return $this->countByDays($request, $product->eventFullAnimationPlayed()->getQuery())->showSumValue();
        }

        return $this->countByDays($request, Models\ProductEvent::fullAnimationPlayed())->showSumValue();
    }

    public function ranges()
    {
        return [
            7 => __('7 Days'),
            14 => __('14 Days'),
            30 => __('30 Days'),
            60 => __('60 Days'),
            90 => __('90 Days'),
        ];
    }

    public function cacheFor()
    {
        return now()->addMinutes(config('app.env') == 'production' ? 5 : 1);
    }

    public function uriKey()
    {
        return 'product-trend-full-animation-plays';
    }
}
