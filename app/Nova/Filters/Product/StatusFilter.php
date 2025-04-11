<?php

namespace App\Nova\Filters\Product;

use App\Enums;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class StatusFilter extends Filter
{
    public $component = 'select-filter';

    public function name()
    {
        return __('Status');
    }

    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where('status', $value);
    }

    public function options(NovaRequest $request)
    {
        return collect(Enums\ProductStatus::cases())->keyBy('name')->map(function ($status) {
            return $status->value;
        })->toArray();
    }
}
