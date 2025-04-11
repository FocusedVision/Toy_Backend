<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth as AuthRequests;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Response;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $auth_service
    ) {
    }

    public function createSessionToken(Request $request)
    {
        $result = $this->auth_service->createSessionToken();

        return Response::send([
            'session_token' => $result,
        ]);
    }

    public function createAccessToken(AuthRequests\TokenRequest $request)
    {
        $result = $this->auth_service->createAccessToken(
            $request->session_token,
            $request->signature,
            $request->device_id
        );

        return Response::send([
            'access_token' => $result,
        ]);
    }
}
