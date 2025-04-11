<?php

namespace App\Nova;

use App\Models;
use App\Rules;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    public static $model = Models\User::class;

    public static $title = 'id';

    public static $search = [
        'id', 'name',
    ];

    public static function label()
    {
        return __('Users');
    }

    public static function singularLabel()
    {
        return __('User');
    }

    public function title()
    {
        return $this->name ?? 'Unknown #'.$this->id;
    }

    public function fields(NovaRequest $request)
    {
        return [
            Fields\ID::make()->sortable(),

            Fields\Text::make(__('Device id'), 'public_device_id')
                ->exceptOnForms(),

            Fields\Text::make(__('Name'), 'name')
                ->nullable()
                ->rules('string', 'max:50', new Rules\ValidNameRule())
                ->sortable(),

            Fields\Image::make(__('Image'), 'image')
                ->onlyOnDetail(),

            ...$this->getTimestampsFields(),

            Fields\BelongsToMany::make(__('Draft products access'), 'draftProductsAccessed', Product::class),
            Fields\BelongsToMany::make(__('Wishlist'), 'products', Product::class),
            Fields\BelongsToMany::make(__('Likes'), 'likes', Product::class),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            Actions\User\SendTestNotificationAction::make(),
        ];
    }
}
