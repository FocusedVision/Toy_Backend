<?php

namespace App\Nova;

use App\Models;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;

class Tag extends Resource
{
    public static $model = Models\Tag::class;

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
        return __('Tags');
    }

    public static function singularLabel()
    {
        return __('Tag');
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
                ->creationRules('unique:tags,name')
                ->updateRules('unique:tags,name,{{resourceId}}')
                ->sortable(),

            Fields\Number::make(__('Products count'), 'products_count')
                ->onlyOnIndex()
                ->sortable(),

            ...$this->getTimestampsFields(),

            Fields\BelongsToMany::make(__('Products'), 'products', Product::class)
                ->filterable(),
        ];
    }
}
