<?php

namespace App\Repositories;

use App\Models\Weekday;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WeekdayRepository extends BaseRepository
{
    public function __construct(Weekday $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $dayName
     * @return Weekday
     * @throws ModelNotFoundException
     */
    public function findByName(string $dayName): Weekday
    {
        return $this->query()->where('name', $dayName)->firstOrFail();
    }
}
