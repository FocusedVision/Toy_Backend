<?php

namespace App\Facades\CloudMessaging\Firebase;

use App\Facades\CloudMessaging\CloudMessagingContract;
use App\Facades\CloudMessaging\Contracts;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\RawMessageFromArray;
use Kreait\Firebase\Exception\MessagingException;

class FirebaseAccessor implements CloudMessagingContract
{
    public function __construct(
        private Messaging $firebase_messaging
    ) {
        //
    }

    public function sendPushesMulticast(Contracts\MessageContract $message, Contracts\RecipientContract ...$recipients): Contracts\SendReportContract
    {
        try {
            $payload = $message->getPayload();
            
            // Log the payload for debugging
            \Log::debug('FCM Payload:', $payload);
            \Log::debug('FCM Recipients:', [
                'tokens' => array_map(fn($r) => $r->getDestination(), $recipients)
            ]);

            $push = new RawMessageFromArray($payload);
            
            $tokens = collect();
            foreach ($recipients as $recipient) {
                $tokens[$recipient->getDestination()] = $recipient;
            }

            $firebase_send_report = $this->firebase_messaging->sendMulticast($push, $tokens->keys()->toArray());
            
            // Add detailed error logging
            \Log::debug('FCM Response:', [
                'success_count' => $firebase_send_report->successes()->count(),
                'failure_count' => $firebase_send_report->failures()->count(),
                'failures' => array_map(function($failure) {
                    return [
                        'token' => $failure->target()->value(),
                        'error' => $failure->error() ? $failure->error()->getMessage() : 'Unknown error'
                    ];
                }, $firebase_send_report->failures()->getItems())
            ]);

            $failed_recipients = [];
            if ($firebase_send_report->hasFailures()) {
                $failures = $firebase_send_report->failures()->getItems();
                foreach ($failures as $failure) {
                    $failed_recipients[] = $tokens[$failure->target()->value()];
                }
            }

            return new SendReport(...$failed_recipients);
        } catch (MessagingException $e) {
            \Log::error('FCM Messaging Error:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('FCM General Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
