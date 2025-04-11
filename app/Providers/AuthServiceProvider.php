<?php

namespace App\Providers;

use App\Models;
use App\Policies;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Models\Admin::class => Policies\AdminPolicy::class,
        Models\Brand::class => Policies\BrandPolicy::class,
        Models\NotificationSetting::class => Policies\NotificationSettingPolicy::class,
        Models\Page::class => Policies\PagePolicy::class,
        Models\Product::class => Policies\ProductPolicy::class,
        Models\Tag::class => Policies\TagPolicy::class,
        Models\User::class => Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
