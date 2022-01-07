<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Shop\SearchRequest;
use App\Http\Resources\Shop\ShopCollection;
use App\Http\Resources\Shop\ShopResource;
use App\Models\Shop;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopController extends Controller
{
    public function search(SearchRequest $request): JsonResource
    {
        $shops = Shop::query()
            ->filter($request->getFilterData())
            ->sort(...$request->getSortData())
            ->paginate($request->query("perPage"));

        return new ShopCollection($shops);
    }

    public function show(Shop $shop): JsonResource
    {
        return new ShopResource($shop);
    }
}
