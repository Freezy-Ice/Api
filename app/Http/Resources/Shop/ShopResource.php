<?php

declare(strict_types=1);

namespace App\Http\Resources\Shop;

use App\Http\Resources\City\CityResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\OpeningHoursResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "city" => new CityResource($this->city),
            "address" => $this->address,
            "description" => $this->description,
            "rating" => $this->rating,
            "avgPrice" => $this->avg_price,
            "coords" => [
                "lat" => $this->lat,
                "lng" => $this->lng,
            ],
            "openingHours" => OpeningHoursResource::collection($this->openingHours),
            "createdAt" => $this->updated_at->format("Y-m-d H:i:s"),
            "updatedAt" => $this->updated_at->format("Y-m-d H:i:s"),
            "favorite" => auth("sanctum")->user() ? $this->favorites->contains(auth("sanctum")->user()) : null,
            "image" => new ImageResource($this->image),
        ];
    }
}
