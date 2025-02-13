<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\ApiExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomResource;
use App\Models\Weekday;
use App\Services\ClassroomService;
use Carbon\Carbon;
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

    public function getSessions(Request $request, int $classroomId): JsonResponse
    {
        $date = $request->query('date') ?? Carbon::now()->format('Y-m-d');
        try {
            return response()->json(
                data: $this->service->getSessions($classroomId, $date),
                status: ResponseStatus::HTTP_OK
            );
        } catch (Throwable $exception) {
            return ApiExceptionHandler::handle($exception);
        }
    }
}
