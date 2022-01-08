<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

/**
 * @property string $name
 * @property string $description
 * @property int $category
 * @property array $flavors
 * @property int $kcal
 * @property int $price
 */
class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "min:3", "max:50"],
            "description" => ["required", "min:3", "max:50"],
            "category" => ["required", "exists:categories,id"],
            "flavors" => ["required", "array"],
            "flavors.*" => ["required", "exists:flavors,id"],
            "kcal" => ["required", "integer"],
            "price" => ["required", "integer"],
            "image" => ["nullable", "exists:images,id"],
        ];
    }

    public function getData(): array
    {
        return [
            "name" => $this->get("name"),
            "description" => $this->get("description"),
            "category_id" => $this->get("category"),
            "kcal" => $this->get("kcal"),
            "price" => $this->get("price"),
        ];
    }

    public function getFlavors(): Collection
    {
        return $this->collect("flavors");
    }

    public function getImage(): ?Image
    {
        /** @var Image $image */
        $image = Image::query()->find($this->get("image"));

        return $image;
    }
}
