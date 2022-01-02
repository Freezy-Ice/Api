<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\Flavor\FlavorResource;
use App\Models\Category;
use App\Models\City;
use App\Models\Flavor;
use Illuminate\Http\Resources\Json\JsonResource;

class DictionaryController extends Controller
{
    public function cities(): JsonResource
    {
        return CityResource::collection(City::all());
    }

    public function categories(): JsonResource
    {
        return CategoryResource::collection(Category::all());
    }

    public function flavors(): JsonResource
    {
        return FlavorResource::collection(Flavor::all());
    }
}
