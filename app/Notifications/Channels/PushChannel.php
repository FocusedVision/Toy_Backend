<?php

namespace App\Notifications\Channels;

use App\Notifications\Contracts\PushNotificationContract;
use App\Repositories;
use CloudMessaging;

class PushChannel
{
    private int $max_failures = 3;

    public function __construct(
        private Repositories\PushTokenRepository $push_token_repository
    ) {
        //
    }

    public function send(mixed $notifiable, PushNotificationContract $notification): void
    {
        $recipients = $notifiable->routeNotificationFor('push', $notification);

        $message = $notification->toPush($notifiable);

        if (count($recipients) > 0) {
            $send_report = CloudMessaging::sendPushesMulticast($message, ...$recipients);

            $failed_recipients = $send_report->getFailedRecipients();

            $to_delete = [];
            $to_update = [];

            foreach ($failed_recipients as $failed_recipient) {
                $failed_recipient->failures_count++;

                if ($failed_recipient->failures_count >= $this->max_failures) {
                    $to_delete[] = $failed_recipient->token;
                } else {
                    $to_update[] = [
                        'user_id' => $failed_recipient->user_id,
                        'token' => $failed_recipient->token,
                        'failures_count' => $failed_recipient->failures_count,
                    ];
                }
            }

            if (count($to_delete) > 0) {
                $this->push_token_repository->deleteArray($to_delete);
            }

            if (count($to_update) > 0) {
                $this->push_token_repository->upsert($to_update);
            }
        }
    }
}
