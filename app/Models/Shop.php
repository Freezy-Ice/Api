<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $city
 * @property string $address
 * @property string $description
 * @property float $lat
 * @property float $lng
 * @property boolean $accepted
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $owner
 * @property Collection $openingHours
 * @property Collection $products
 */
class Shop extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    public function accept(): void
    {
        $this->accepted = true;

        $this->save();
    }

    public function scopeUnaccepted(Builder $query): Builder
    {
        return $query->where("accepted", false);
    }
}
