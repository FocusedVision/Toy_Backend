<?php

namespace App\Facades\CloudMessaging\Firebase;

use App\Facades\CloudMessaging\Contracts;

class SendReport implements Contracts\SendReportContract
{
    private array $recipients;

    public function __construct(Contracts\RecipientContract ...$recipients)
    {
        $this->recipients = $recipients;
    }

    public function getFailedRecipients(): array
    {
        return $this->recipients;
    }
}
