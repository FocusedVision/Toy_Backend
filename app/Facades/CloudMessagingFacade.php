<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CloudMessagingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CloudMessagingAccessor';
    }
}
