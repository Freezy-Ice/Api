<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use App\Enums\DayOfWeek;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

/**
 * @property string $name
 * @property string $city
 * @property string $address
 * @property string $description
 * @property array $coords
 * @property array $openingHours
 */
class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => ["required", "min:3", "max:50"],
            "city" => ["required"],
            "address" => ["required", "min:3", "max:50"],
            "description" => ["required", "min:3", "max:500"],
            "coords" => ["required", "array"],
            "coords.lat" => ["required", "numeric"],
            "coords.lng" => ["required", "numeric"],
            "openingHours" => ["required", "array"],
            "openingHours.*.day" => ["required", new Enum(DayOfWeek::class)],
            "openingHours.*.from" => ["required", "date_format:G:i"],
            "openingHours.*.to" => ["required", "date_format:G:i"],
            "openingHours.*.open" => ["required", "boolean"]
        ];
    }

    public function getUpdateData(): array
    {
        return [
            "name" => $this->get("name"),
            "city" => $this->get("city"),
            "address" => $this->get("address"),
            "description" => $this->get("description"),
            "lat" => $this->input("coords.lat"),
            "lng" => $this->input("coords.lng"),
        ];
    }

    public function getOpeningHours(): array
    {
        return $this->get("openingHours");
    }
}
