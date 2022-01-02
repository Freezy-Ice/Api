<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DayOfWeek;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $shop_id
 * @property DayOfWeek $day
 * @property string $from
 * @property string $to
 * @property boolean $open
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Shop $shop
 */
class OpeningHour extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "day" => DayOfWeek::class,
        "open" => "boolean",
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
