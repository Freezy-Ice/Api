<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function getSortData(): array
    {
        return [
            "sort" => $this->get("sort", "default"),
            "direction" => $this->get("direction", "asc"),
        ];
    }

    public function getFilterData(): array
    {
        $data = [];

        if ($this->has("search")) {
            $data["search"] = $this->get("search");
        }

        if ($this->has("city")) {
            $data["city"] = $this->get("city");
        }

        if ($this->has("category")) {
            $data["category"] = Arr::wrap($this->get("category"));
        }

        if ($this->has("flavor")) {
            $data["flavor"] = Arr::wrap($this->get("flavor"));
        }

        if ($this->has("priceMin")) {
            $data["priceMin"] = (int)$this->get("priceMin");
        }

        if ($this->has("priceMax")) {
            $data["priceMax"] = (int)$this->get("priceMax");
        }

        if ($this->boolean("favorite")) {
            $data["favorite"] = $this->user();
        }

        if ($this->boolean("openNow")) {
            $data["openNow"] = Carbon::now();
        }

        return $data;
    }
}
