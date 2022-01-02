<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class City extends Model
{
    use HasFactory;

    protected $guarded = [];
}
