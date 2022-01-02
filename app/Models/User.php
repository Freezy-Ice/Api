<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property bool $company_account
 * @property Collection $shops
 * @property Collection $favoriteShops
 * @property Collection $reviews
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected $casts = [
        "company_account" => "bool",
    ];

    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }

    public function favoriteShops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class, "favorites");
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeCompanyAccounts(Builder $query): Builder
    {
        return $query->where("company_account", true);
    }
}
