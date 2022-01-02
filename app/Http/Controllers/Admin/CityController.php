<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Http\Resources\City\CityCollection;
use App\Http\Resources\City\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class CityController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $citiess = City::query()->paginate($request->query("perPage"));

        return new CityCollection($citiess);
    }

    public function store(CityRequest $request): JsonResource
    {
        $city = City::query()->create($request->getData());

        return new CityResource($city);
    }

    public function show(City $city): JsonResource
    {
        return new CityResource($city);
    }

    public function update(CityRequest $request, City $city): JsonResource
    {
        $city->update($request->getData());

        return new CityResource($city);
    }

    public function destroy(City $city): Response
    {
        $city->delete();

        return response()->noContent();
    }
}
