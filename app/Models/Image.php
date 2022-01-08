<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property Shop $shop
 * @property Product $product
 */
class Image extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $guarded = [];
    protected $keyType = "string";

    public function attachmentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function shop(): MorphOne
    {
        return $this->morphOne(Shop::class, "imageable");
    }

    public function assignment(): MorphOne
    {
        return $this->morphOne(Product::class, "imageable");
    }
}
