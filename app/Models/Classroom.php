<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property string $name
 * @property int $capacity
 * @property string $description
 */
class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'description',
    ];
}
