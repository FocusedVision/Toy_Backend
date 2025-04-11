<?php

namespace App\Nova;

use App\Models;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;

class Page extends Resource
{
    public static $model = Models\Page::class;

    public static $title = 'title';

    public static $search = [
        'title',
    ];

    public static function label()
    {
        return __('Pages');
    }

    public static function singularLabel()
    {
        return __('Page');
    }

    public static function createButtonLabel()
    {
        return __('Create');
    }

    public static function updateButtonLabel()
    {
        return __('Update');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Fields\ID::make()->sortable(),

            Fields\Text::make(__('Title'), 'title')
                ->sortable()
                ->rules('required', 'max:255'),

            Fields\Text::make(__('Slug'), 'slug')
                ->sortable()
                ->rules('required', 'alpha_dash', 'max:255'),

            Fields\Trix::make(__('Content'), 'content')
                ->rules('required', 'max:16000000'),

            ...$this->getTimestampsFields(),
        ];
    }
}
