<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\ApiExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use Throwable;

class EventController extends Controller
{

    public function __construct(protected EventService $service) {}

    public function index(Request $request): JsonResponse
    {
        try {
            return response()->json(
              data: EventResource::collection($this->service->getEvents()),
              status: ResponseStatus::HTTP_OK
            );
        } catch (Throwable $exception) {
            return ApiExceptionHandler::handle($exception);
        }
    }

    public function store()
    {
        //
    }

    public function show()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }

    public function sessions(Request $request): JsonResponse
    {
        $classroomId = $request->get('classroom_id');
        $date = $request->get('date');

        try {
            return response()->json(
                data: $this->service->getDateSessions($classroomId, $date),
                status: ResponseStatus::HTTP_OK,
            );
        } catch (Throwable $exception) {
            return ApiExceptionHandler::handle($exception);
        }
    }
}
