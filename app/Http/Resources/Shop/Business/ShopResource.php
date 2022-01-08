<?php

declare(strict_types=1);

namespace App\Http\Resources\Shop\Business;

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
            "coords" => [
                "lat" => $this->lat,
                "lng" => $this->lng,
            ],
            "openingHours" => OpeningHoursResource::collection($this->openingHours),
            "createdAt" => $this->updated_at->format("Y-m-d H:i:s"),
            "updatedAt" => $this->updated_at->format("Y-m-d H:i:s"),
            "accepted" => $this->accepted,
            "image" => new ImageResource($this->image),
        ];
    }
}
