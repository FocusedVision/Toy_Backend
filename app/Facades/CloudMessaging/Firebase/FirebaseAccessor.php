<?php

namespace App\Facades\CloudMessaging\Firebase;

use App\Facades\CloudMessaging\CloudMessagingContract;
use App\Facades\CloudMessaging\Contracts;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\RawMessageFromArray;

class FirebaseAccessor implements CloudMessagingContract
{
    public function __construct(
        private Messaging $firebase_messaging
    ) {
        //
    }

    public function sendPushesMulticast(Contracts\MessageContract $message, Contracts\RecipientContract ...$recipients): Contracts\SendReportContract
    {
        $push = new RawMessageFromArray($message->getPayload());

        $tokens = collect();

        foreach ($recipients as $recipient) {
            $tokens[$recipient->getDestination()] = $recipient;
        }

        $firebase_send_report = $this->firebase_messaging->sendMulticast($push, $tokens->keys()->toArray());

        $failed_recipients = [];

        if ($firebase_send_report->hasFailures()) {
            $failures = $firebase_send_report->failures()->getItems();

            foreach ($failures as $failure) {
                $failed_recipients[] = $tokens[$failure->target()->value()];
            }
        }

        return new SendReport(...$failed_recipients);
    }
}
