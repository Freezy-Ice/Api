<?php

declare(strict_types=1);

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreRequest;
use App\Http\Requests\Shop\UpdateRequest;
use App\Http\Resources\PaginatedCollection;
use App\Http\Resources\Shop\Business\ShopCollection;
use App\Http\Resources\Shop\Business\ShopResource;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ShopController extends Controller
{
    public function index(Request $request): PaginatedCollection
    {
        $shops = $request->user()->shops()->paginate($request->query("perPage"));

        return new ShopCollection($shops);
    }

    public function store(StoreRequest $request): JsonResource
    {
        $shops = $request->user()
            ->shops()
            ->create($request->getStoreData())
            ->refresh();

        return new ShopResource($shops);
    }

    public function show(Shop $shop): JsonResource
    {
        return new ShopResource($shop);
    }

    public function update(UpdateRequest $request, Shop $shop): JsonResource
    {
        $shop->update($request->getUpdateData());

        $shop->openingHours()->delete();
        $shop->openingHours()->createMany($request->getOpeningHours());

        return new ShopResource($shop);
    }

    public function destroy(Shop $shop): Response
    {
        $shop->delete();

        return response()->noContent();
    }
}
