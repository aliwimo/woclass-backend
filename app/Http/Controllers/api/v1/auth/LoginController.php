<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Exceptions\ApiExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Throwable;

class LoginController extends Controller
{

    public function __construct( protected AuthService $service) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            return $this->service->login($request);
        } catch (Throwable $exception) {
            return ApiExceptionHandler::handle($exception);
        }
    }
}
