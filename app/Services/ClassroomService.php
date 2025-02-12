<?php

namespace App\Services;

use App\Repositories\ClassroomRepository;
use Illuminate\Database\Eloquent\Collection;

class ClassroomService
{
    public function __construct(protected ClassroomRepository $repository) {}

    public function getClassrooms(): Collection
    {
        return $this->repository->all();
    }
}
