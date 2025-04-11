<?php

namespace App\Facades\CloudMessaging;

interface CloudMessagingContract
{
    public function sendPushesMulticast(Contracts\MessageContract $message, Contracts\RecipientContract ...$recipients): Contracts\SendReportContract;
}
