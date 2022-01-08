<?php

declare(strict_types=1);

namespace App\Http\Resources\Product\Business;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Flavor\FlavorResource;
use App\Http\Resources\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "category" => new CategoryResource($this->category),
            "flavors" => FlavorResource::collection($this->flavors),
            "kcal" => $this->kcal,
            "price" => $this->price,
            "image" => new ImageResource($this->image),
        ];
    }
}
