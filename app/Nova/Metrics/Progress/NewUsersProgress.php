<?php

namespace App\Nova\Metrics\Progress;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Progress;

class NewUsersProgress extends Progress
{
    private int $target = 100;

    public function name()
    {
        return __('New users target')." ({$this->target})";
    }

    public function calculate(NovaRequest $request)
    {
        return $this->count($request, User::class, function ($query) {
            return $query;
        }, target: $this->target);
    }

    public function cacheFor()
    {
        return now()->addMinutes(config('app.env') == 'production' ? 5 : 1);
    }

    public function uriKey()
    {
        return 'new-users-progress';
    }
}
