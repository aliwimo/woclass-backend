<?php

namespace App\Services;

use App\Enums\SessionStatus;
use App\Repositories\WeekdayRepository;
use Carbon\Carbon;

class SessionService
{
    public function __construct(protected WeekdayRepository $repository) {}



    public function generateSessions($weekday): array
    {
        $sessions = [];
        $startTime = Carbon::parse($weekday->start_time);
        $endTime = Carbon::parse($weekday->end_time);
        $duration = $weekday->session_duration;

        while ($startTime->addMinutes($duration)->lte($endTime)) {
            $sessions[] = [
                'start_time' => $startTime->copy()->subMinutes($duration)->format('H:i'),
                'end_time' => $startTime->format('H:i'),
                'status' => SessionStatus::AVAILABLE->value,
            ];
        }

        return $sessions;
    }

    public function markReservedSessions(array $sessions, $events): array
    {
        return array_map(function ($session) use ($events) {
            $isReserved = $events->contains(fn($event) =>
                $event['start_time'] === $session['start_time'] &&
                $event['end_time'] === $session['end_time']
            );

            $session['status'] = $isReserved ? SessionStatus::RESERVED->value : SessionStatus::AVAILABLE->value;
            return $session;
        }, $sessions);
    }
}
