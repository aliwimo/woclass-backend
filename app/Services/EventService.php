<?php

namespace App\Services;

use App\Enums\EventStatus;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Repositories\EventRepository;
use App\Repositories\WeekdayRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EventService
{
    public function __construct(
        protected EventRepository $eventRepository,
        protected WeekdayRepository $weekdayRepository,
    ) {}

    public function getAllEvents(): Collection
    {
        return $this->eventRepository->all();
    }

    public function getEvents(int $classroomId, string $date): Collection
    {
        return $this->eventRepository->getPreservedEvents($classroomId, $date)
            ->map(function (Event $event) {
                return [
                    'start_time' => Carbon::parse($event->start_time)->format('H:i'),
                    'end_time' => Carbon::parse($event->end_time)->format('H:i'),
                ];
            });
    }

    /**
     * @throws Exception
     */
    public function reserve(StoreEventRequest $request): Model
    {
        $dayName = Carbon::parse($request->date)->dayName;
        $weekday = $this->weekdayRepository->findByName($dayName);

        if (!$weekday->is_working_day) {
            throw new Exception(
                message: 'Reservations are not allowed on this day.',
                code: 422
            );
        }

        $isEventExists = $this->eventRepository->eventExists(
            classroomId: $request->classroom_id,
            date: $request->date,
            startTime: $request->start_time,
            endTime: $request->end_time,
        );

        if ($isEventExists) {
            throw new Exception(
                message: 'This session is already reserved.',
                code: 422
            );
        }

        return $this->eventRepository->create([
            'classroom_id' => $request->classroom_id,
            'user_id' => $request->user_id,
            'weekday_id' => $weekday->id,
            'title' => $request->title,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'status' => EventStatus::SCHEDULED->value
        ]);
    }
}
