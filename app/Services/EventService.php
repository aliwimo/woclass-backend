<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    public function __construct(protected EventRepository $repository) {}

    public function getEvents(): Collection
    {
        return $this->repository->all();
    }

    public function getDateSessions(int $classroomId, string $date)
    {

        // Convert the date to Carbon for easier manipulation
        $carbonDate = Carbon::parse($date);

        // Get the day name to find the corresponding week_day configuration
        $dayName = $carbonDate->format('l');

        return $this->repository->query()
            ->with(['user', 'weekday']) // Eager load relationships
            ->where('classroom_id', $classroomId)
            ->where('date', $date)
            ->whereHas('weekday', function ($query) use ($dayName) {
                $query->where('name', $dayName)
                    ->where('is_working_day', true);
            })
            ->orderBy('start_time')
            ->get()
            ->map(function (Event $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'status' => $event->status,
                    'user' => [
                        'id' => $event->user->id,
                        'name' => $event->user->name,
                        'email' => $event->user->email,
                    ],
                    'duration' => $event->weekday->session_duration . ' minutes',
                ];
            });

    }
}
