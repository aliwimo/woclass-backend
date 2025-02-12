<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\ApiExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomResource;
use App\Services\ClassroomService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use Throwable;

class ClassroomController extends Controller
{

    public function __construct(protected ClassroomService $service) {}

    public function index(Request $request): JsonResponse
    {
        try {
            return response()->json(
                data: ClassroomResource::collection($this->service->getClassrooms()),
                status: ResponseStatus::HTTP_OK
            );
        } catch (Throwable $exception) {
            return ApiExceptionHandler::handle($exception);
        }
    }
}
