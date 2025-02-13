<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\ApiExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
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
              data: EventResource::collection($this->service->getallEvents()),
              status: ResponseStatus::HTTP_OK
            );
        } catch (Throwable $exception) {
            return ApiExceptionHandler::handle($exception);
        }
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        try {
            return response()->json(
                data: EventResource::make($this->service->reserve($request)),
                status: ResponseStatus::HTTP_CREATED
            );
        } catch (Throwable $exception) {
            return ApiExceptionHandler::handle($exception);
        }
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
}
