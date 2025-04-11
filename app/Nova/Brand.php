<?php

namespace App\Nova;

use App\Models;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;

class Brand extends Resource
{
    public static $model = Models\Brand::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public static function group()
    {
        return __('Product');
    }

    public static function label()
    {
        return __('Brands');
    }

    public static function singularLabel()
    {
        return __('Brand');
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCount('products');
    }

    public static function detailQuery(NovaRequest $request, $query)
    {
        return $query->with('products')->withCount('products');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Fields\ID::make()->sortable(),

            Fields\Text::make(__('Name'), 'name')
                ->required()
                ->rules('string', 'max:100')
                ->creationRules('unique:brands,name')
                ->updateRules('unique:brands,name,{{resourceId}}')
                ->sortable(),

            Fields\Number::make(__('Products count'), 'products_count')
                ->onlyOnIndex()
                ->sortable(),

            ...$this->getTimestampsFields(),

            Fields\HasMany::make(__('Products'), 'products', Product::class),
        ];
    }
}
