<?php

namespace App\Notifications\Messages;

use App\Facades\CloudMessaging\Contracts\MessageContract;
use App\Traits\Makeable;
use Str;
use UnitEnum;

class PushMessage implements MessageContract
{
    use Makeable;

    private ?string $title = null;
    private ?string $body = null;
    private array $data = [];

    public function title(string $title = null): self
    {
        $this->title = $title;
        return $this;
    }

    public function body(string $body = null): self
    {
        $this->body = $body;
        return $this;
    }

    public function data(string $key, mixed $value): self
    {
        $key = (string) Str::of($key)->camel();

        if ($value instanceof UnitEnum) {
            $value = strval($value->value);
        } elseif (is_array($value)) {
            $value = json_encode($value);
        } elseif (is_object($value) && method_exists($value, 'toString')) {
            $value = $value->toString();
        } else {
            $value = strval($value);
        }

        $this->data[$key] = $value;
        return $this;
    }

    public function getPayload(): array
    {
        $notification = ['title' => $this->title ?? ''];
        
        if ($this->body !== null) {
            $notification['body'] = $this->body;
        }

        return [
            'notification' => $notification,
            'android' => [
                'priority' => 'high',
                'notification' => [
                    'channel_id' => 'default',
                    'sound' => 'default',
                    'visibility' => 'public',
                    'default_sound' => true,
                    'default_vibrate_timings' => true,
                ],
            ],
            'apns' => [
                'payload' => [
                    'aps' => [
                        'sound' => 'default',
                        'badge' => 1,
                    ],
                ],
            ],
            'data' => $this->data,
        ];
    }
}
