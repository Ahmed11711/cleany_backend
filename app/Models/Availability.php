<?php

namespace App\Models;

use \App\Enums\DayOfWeek;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Availability extends Model
{

    protected $casts = [
        // 'day_of_week' => DayOfWeek::class,
    ];
    protected function dayOfWeek(): Attribute
    {
        return Attribute::make(
            get: fn($value) => is_numeric($value)
                ? DayOfWeek::from($value)->name
                : (is_object($value) ? $value->name : $value),
        );
    }
}
