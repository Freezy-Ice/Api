<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpeningHour extends Model
{
    use HasFactory;
    protected $table = "opening_hours";

    protected $guarded = [];

    protected $casts = [
        "open" => "boolean",
    ];

    public function iceCreamShop(): BelongsTo
    {
        return $this->belongsTo(IceCreamShop::class);
    }
}
