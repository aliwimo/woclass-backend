<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $classroom_id
 * @property int $user_id
 * @property int $weekday_id
 * @property string $title
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property string $description
 * @property EventStatus $status
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'user_id',
        'weekday_id',
        'title',
        'date',
        'start_time',
        'end_time',
        'description',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => EventStatus::class,
    ];
}
