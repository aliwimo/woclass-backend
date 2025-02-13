<?php

namespace App\Enums;

enum SessionStatus: string
{
    case RESERVED = 'reserved';
    case AVAILABLE = 'available';
}
