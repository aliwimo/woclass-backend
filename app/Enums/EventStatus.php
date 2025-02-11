<?php

namespace App\Enums;

enum EventStatus: string
{
    case SCHEDULED = 'scheduled';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
