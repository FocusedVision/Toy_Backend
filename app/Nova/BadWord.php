<?php

namespace App\Nova;

use App\Models;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;

class BadWord extends Resource
{
    public static $model = Models\BadWord::class;

    public static $title = 'word';

    public static $search = [
        'word',
    ];

    public static $globallySearchable = false;

    public function fields(NovaRequest $request)
    {
        return [
            Fields\ID::make()->sortable(),

            Fields\Text::make(__('Word'), 'word')
                ->required()
                ->rules('string', 'max:100')
                ->creationRules('unique:bad_words,word')
                ->updateRules('unique:bad_words,word,{{resourceId}}')
                ->sortable(),

            ...$this->getTimestampsFields(),
        ];
    }
}
