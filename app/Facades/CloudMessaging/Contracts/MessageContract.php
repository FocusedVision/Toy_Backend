<?php

namespace App\Facades\CloudMessaging\Contracts;

interface MessageContract
{
    public function getPayload(): array;
}
