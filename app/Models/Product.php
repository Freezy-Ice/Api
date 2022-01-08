<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $kcal
 * @property int $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Shop $shop
 * @property Category $category
 * @property Image $image
 * @property Collection $flavors
 */
class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $touches = ["shop"];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function flavors(): BelongsToMany
    {
        return $this->belongsToMany(Flavor::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, "imageable");
    }
}
