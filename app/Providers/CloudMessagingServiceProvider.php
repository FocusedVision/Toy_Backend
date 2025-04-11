<?php

namespace App\Providers;

use App\Facades\CloudMessaging;
use Illuminate\Support\ServiceProvider;

class CloudMessagingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CloudMessagingAccessor', function () {
            return $this->app->make(CloudMessaging\Firebase\FirebaseAccessor::class);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
