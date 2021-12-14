<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IceCreamShop extends Model
{
    use HasFactory;
    protected $table = "ice_cream_shops";

    protected $fillable = [
        "name",
        "city",
        "address",
        "description",
        "lat",
        "lng",
    ];

    protected $casts = [
        "accepted" => "boolean",
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function openingHours(): HasMany
    {
        return $this->hasMany(OpeningHour::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
