<?php

namespace App\Services;

use App\Repositories\ClassroomRepository;
use App\Repositories\WeekdayRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ClassroomService
{
    public function __construct(
        protected ClassroomRepository $classroomRepository,
        protected WeekdayRepository $weekdayRepository,
        protected EventService $eventService,
        protected SessionService $sessionService
    ) {}

    public function getClassrooms(): Collection
    {
        return $this->classroomRepository->all();
    }

    public function getSessions(int $classroomId, string $date): array
    {
        $weekday = $this->weekdayRepository->findByName(Carbon::parse($date)->dayName);
        if (!$weekday->is_working_day) {
            return [];
        }
        $sessions = $this->sessionService->generateSessions($weekday);
        $events = $this->eventService->getEvents($classroomId, $date);
        return $this->sessionService->markReservedSessions($sessions, $events);
    }
}
