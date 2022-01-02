<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            "flavors.*.id" => ["required", "exists:flavors,id"],
            "kcal" => ["required", "integer"],
            "price" => ["required", "integer"],
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

    public function getFlavors(): array
    {
        return array_map(function ($flavor) {
            return [
                "flavor_id" => $flavor["id"],
            ];
        }, $this->get("flavors"));
    }
}
