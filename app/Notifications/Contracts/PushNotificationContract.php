<?php

namespace App\Notifications\Contracts;

use App\Notifications\Messages\PushMessage;

interface PushNotificationContract
{
    public function toPush(mixed $notifiable): PushMessage;
}
