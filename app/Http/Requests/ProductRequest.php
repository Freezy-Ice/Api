<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required"],
            "description" => ["required"],
            "category_id" => ["required", "exists:categories,id"],
            "flavors.*.flavor_id" => ["required", "exists:flavors,id"],
            "kcal" => ["required", "integer"],
            "price" => ["required", "integer"],
        ];
    }

    public function getData(): array
    {
        return $this->only("name", "description", "category_id", "kcal", "price");
    }
}
