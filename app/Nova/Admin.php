<?php

namespace App\Nova;

use App\Enums;
use App\Models;
use App\Nova\Fields as CustomFields;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;

class Admin extends Resource
{
    public static $model = Models\Admin::class;

    public static $title = 'name';

    public static $search = [
        'name', 'email',
    ];

    public static function label()
    {
        return __('Admins');
    }

    public static function singularLabel()
    {
        return __('Admin');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Fields\ID::make()->sortable(),

            Fields\Text::make(__('Name'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Fields\Text::make(__('Email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:admins,email')
                ->updateRules('unique:admins,email,{{resourceId}}'),

            Fields\Password::make(__('Password'), 'password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),

            CustomFields\Enum::make(__('Role'), 'role', Enums\AdminRole::class)->showOnUpdating(function ($request) {
                return $request->user()->isModerator() && $this->id !== $request->user()->id;
            })->help(
                '<b>'.__('Viewer').'</b> - '.__('allows only data viewing').'<br>'.
                '<b>'.__('Editor').'</b> - '.__('allows you to edit data').'<br>'.
                '<b>'.__('Moderator').'</b> - '.__('allows you to edit data, create administrators and manage their roles')
            ),

            ...$this->getTimestampsFields(),
        ];
    }
}
