<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $session_duration
 * @property string $start_time
 * @property string $end_time
 * @property bool $is_working_day
 */
class Weekday extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'session_duration',
        'start_time',
        'end_time',
        'is_working_day'
    ];

    protected $casts = [
        'is_working_day' => 'boolean',
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];
}
