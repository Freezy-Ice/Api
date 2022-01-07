<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DayOfWeek;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $description
 * @property float $lat
 * @property float $lng
 * @property float $rating
 * @property int $avg_price
 * @property boolean $accepted
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $owner
 * @property City $city
 * @property Collection $openingHours
 * @property Collection $products
 * @property Collection $reviews
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
        return $this->belongsTo(User::class, "user_id");
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function openingHours(): HasMany
    {
        return $this->hasMany(OpeningHour::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "favorites");
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

    public function scopeSort(Builder $query, string $sortBy, string $direction): Builder
    {
        return match ($sortBy) {
            "price" => $query->orderBy("avg_price", $direction),
            "rating" => $query->orderBy("rating", $direction),
            "updated_at" => $query->orderBy("updated_at", $direction),
            default => $query->orderBy("name", $direction),
        };
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $value) {
            $this->applyFilter($query, $key, $value);
        }

        return $query;
    }

    public function scopeOpenNow(Builder $query, Carbon $now): Builder
    {
        $dayOfWeek = DayOfWeek::fromCarbon($now);

        return $query->whereRelation(
            "openingHours",
            fn(Builder $query) => $query->where("day", $dayOfWeek->value)
                ->where("open", true)
                ->whereTime("from", "<=", $now)
                ->whereTime("to", ">", $now),
        );
    }

    public function scopeByCategory(Builder $query, array $values): Builder
    {
        return $query->whereHas("products", fn(Builder $query) => $query->whereIn("category_id", $values));
    }

    public function scopeByFlavor(Builder $query, array $values): Builder
    {
        return $query->whereHas("products", fn(Builder $query) => $query->whereHas("flavors", fn(Builder $query) => $query->whereIn("id", $values)));
    }

    public function scopeByFavorite(Builder $query, User $favorite): Builder
    {
        return $query->whereRelation("favorites", "id", $favorite->id);
    }

    protected function applyFilter(Builder $query, string $filter, mixed $value): Builder
    {
        return match ($filter) {
            "search" => $query->where("name", "LIKE", "%{$value}%"),
            "city" => $query->where("city_id", $value),
            "category" => $this->scopeByCategory($query, $value),
            "flavor" => $this->scopeByFlavor($query, $value),
            "favorite" => $this->scopeByFavorite($query, $value),
            "openNow" => $this->scopeOpenNow($query, $value),
            default => $query,
        };
    }
}
