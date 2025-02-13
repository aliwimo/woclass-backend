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
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '>=', $startTime)
                        ->where('end_time', '<=', $endTime);
                });
            })
            ->exists();
    }
}
