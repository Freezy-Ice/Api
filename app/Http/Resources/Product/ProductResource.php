<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\FlavorResource;
use App\Models\Flavor;

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
            "price" => $this->price
        ];
    }
}
