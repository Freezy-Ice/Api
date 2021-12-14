<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\IceCreamShop\IceCreamShopRequest;
use App\Http\Requests\IceCreamShop\StoreRequest;
use App\Http\Resources\IceCreamShop\IceCreamShopCollection;
use App\Http\Resources\IceCreamShop\IceCreamShopResource;
use App\Http\Resources\IceCreamShop\StoreResource;
use App\Http\Resources\PaginatedCollection;
use App\Models\IceCreamShop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class IceCreamShopController extends Controller
{
    public function index(Request $request): PaginatedCollection
    {
        $iceCreamShops = $request->user()->iceCreamShops()->paginate();

        return new IceCreamShopCollection($iceCreamShops);
    }

    public function store(StoreRequest $request): JsonResource
    {
        $iceCreamShop = $request->user()
            ->iceCreamShops()
            ->create($request->getStoreData())
            ->refresh();

        return new StoreResource($iceCreamShop);
    }

    public function show(IceCreamShop $iceCreamShop): JsonResource
    {
        return new IceCreamShopResource($iceCreamShop);
    }

    public function update(IceCreamShopRequest $request, IceCreamShop $iceCreamShop): JsonResource
    {
        $iceCreamShop->update([
            $request->getUpdateData(),
            "lat" => $request->coords["lat"],
            "lng" => $request->coords["lng"],
        ]);

        $iceCreamShop->openingHours()->delete();
        $iceCreamShop->openingHours()->createMany($request->getOpeningHours());

        return new IceCreamShopResource($iceCreamShop);
    }

    public function delete(IceCreamShop $iceCreamShop): Response
    {
        $iceCreamShop->delete();

        return response([
            "message" => "Usunięto lodziarnę",
        ]);
    }
}
