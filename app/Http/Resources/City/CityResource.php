<?php

declare(strict_types=1);

namespace App\Http\Resources\City;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
        ];
    }
}
