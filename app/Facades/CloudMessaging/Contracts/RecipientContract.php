<?php

namespace App\Facades\CloudMessaging\Contracts;

interface RecipientContract
{
    public function getDestination(): string;
}
