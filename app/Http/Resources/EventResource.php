<?php

namespace App\Http\Resources;

use App\Enums\EventStatus;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Event */
class EventResource extends JsonResource
{
    /**
     * @inheritDoc
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->whenNotNull($this->title),
            'date' => $this->whenNotNull($this->date),
            'start_time' => $this->whenNotNull($this->start_time),
            'end_time' => $this->whenNotNull($this->end_time),
            'description' => $this->whenNotNull($this->description),
            'status' => $this->whenNotNull($this->status->value),
        ];
    }
}
