<?php

namespace App\Repositories;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class EventRepository extends BaseRepository
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    public function getPreservedEvents(int $classroomId, string $date): Collection
    {
        return $this->query()
            ->where('classroom_id', $classroomId)
            ->where('date', $date)
            ->get(['start_time', 'end_time']);
    }

    public function eventExists(int $classroomId, string $date, string $startTime, string $endTime): bool
    {
        return $this->query()
            ->where('classroom_id', $classroomId)
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime]);
            })
            ->exists();
    }
}
