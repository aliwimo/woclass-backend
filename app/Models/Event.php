<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 *
 * @property Classroom $classroom
 * @property User $user
 * @property Weekday $weekday
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
        'date' => 'datetime:Y-m-d',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'status' => EventStatus::class,
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(related: Classroom::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }

    public function weekday(): BelongsTo
    {
        return $this->belongsTo(related: Weekday::class);
    }
}
