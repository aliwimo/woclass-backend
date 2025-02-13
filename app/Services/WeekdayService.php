<?php

namespace App\Services;

use App\Repositories\WeekdayRepository;

class WeekdayService
{
    public function __construct(protected WeekdayRepository $repository) {}
}
