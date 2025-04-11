<?php

namespace App\Services\Auth;

use App\Repositories\UserRepository;
use Response;
use Str;

class AuthService
{
    private string $secret_key;

    public function __construct(
        private UserRepository $user_repository
    ) {
        $this->secret_key = config('auth.secret_key');
    }

    public function createSessionToken(): string
    {
        $session_token = Str::random(16);

        $this->saveSessionToken($session_token);

        return $session_token;
    }

    private function saveSessionToken(string $session_token): void
    {
        cache()->put('session_token_'.$session_token, true, 1800);
    }

    public function createAccessToken(string $session_token, string $signature, string $device_id = null): string
    {
        abort_unless($this->checkSessionToken($session_token), Response::UNAUTHORIZED, __('Invalid session token'));

        $verification_signature = $this->generateSignature($session_token);

        abort_unless($verification_signature === $signature, Response::UNAUTHORIZED, __('Invalid signature'));

        $this->flushSessionToken($session_token);

        return $this->generateAccessToken($device_id);
    }

    private function checkSessionToken(string $session_token): bool
    {
        return cache()->get('session_token_'.$session_token, false) === true;
    }

    private function generateSignature(string $session_token): string
    {
        return hash('sha256', $session_token.$this->secret_key);
    }

    private function flushSessionToken(string $session_token): void
    {
        cache()->forget('session_token_'.$session_token);
    }

    private function generateAccessToken(string $device_id = null): string
    {
        $user = $this->user_repository->firstOrCreateByDeviceId($device_id);

        return $this->user_repository->createAccessToken($user)->plainTextToken;
    }
}
