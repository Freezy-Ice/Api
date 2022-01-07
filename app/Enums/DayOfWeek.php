<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Carbon;

enum DayOfWeek: string
{
    case MONDAY = "monday";
    case TUESDAY = "tuesday";
    case WEDNESDAY = "wednesday";
    case THURSDAY = "thursday";
    case FRIDAY = "friday";
    case SATURDAY = "saturday";
    case SUNDAY = "sunday";

    public static function fromCarbon(Carbon $carbon): DayOfWeek
    {
        return match ($carbon->dayOfWeek) {
            0 => DayOfWeek::SUNDAY,
            1 => DayOfWeek::MONDAY,
            2 => DayOfWeek::TUESDAY,
            3 => DayOfWeek::WEDNESDAY,
            4 => DayOfWeek::THURSDAY,
            5 => DayOfWeek::FRIDAY,
            6 => DayOfWeek::SATURDAY,
        };
    }
}
