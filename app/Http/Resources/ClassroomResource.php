<?php

namespace App\Http\Resources;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Classroom */
class ClassroomResource extends JsonResource
{
    /**
     * @inheritDoc
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenNotNull($this->name),
            'capacity' => $this->whenNotNull($this->capacity),
            'description' => $this->whenNotNull($this->description),
        ];
    }
}
