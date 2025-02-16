<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Exceptions\ApiExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Throwable;

class RegisterController extends Controller
{
    public function __construct( protected AuthService $service) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            return $this->service->register($request);
        } catch (Throwable $exception) {
            return ApiExceptionHandler::handle($exception);
        }
    }
}
