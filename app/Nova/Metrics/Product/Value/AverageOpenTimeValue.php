<?php

namespace App\Nova\Metrics\Product\Value;

use App\Models;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class AverageOpenTimeValue extends Value
{
    public function name()
    {
        return __('Average open time');
    }

    public function calculate(NovaRequest $request)
    {
        if ($request->resourceId !== null) {
            $product = Models\Product::find($request->resourceId);

            return $this->average($request, $product->eventOpenTimeSeconds()->getQuery(), 'seconds')->suffix('seconds');
        }

        return $this->average($request, Models\ProductEvent::openTimeSeconds(), 'seconds')->suffix('seconds');
    }

    public function ranges()
    {
        return [
            'TODAY' => __('Today'),
            'YESTERDAY' => __('Yesterday'),
            7 => __('7 Days'),
            'MTD' => __('Month To Date'),
            'QTD' => __('Quarter To Date'),
            'YTD' => __('Year To Date'),
            'ALL' => __('All Time'),
        ];
    }

    public function cacheFor()
    {
        return now()->addMinutes(config('app.env') == 'production' ? 5 : 1);
    }

    public function uriKey()
    {
        return 'product-value-average-open-time';
    }
}
