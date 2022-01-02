<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $city
 * @property string $address
 * @property string $description
 */
class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "min:3", "max:50"],
            "city" => ["required"],
            "address" => ["required", "min:3", "max:50"],
            "description" => ["required", "min:3", "max:500"],
        ];
    }

    public function getStoreData(): array
    {
        return $this->only("name", "city", "address", "description");
    }
}
