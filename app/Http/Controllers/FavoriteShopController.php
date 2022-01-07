<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Shop\ShopCollection;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class FavoriteShopController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $shops = $request->user()
            ->favoriteShops()
            ->with(["openingHours", "city"])
            ->paginate($request->query("perPage"));

        return new ShopCollection($shops);
    }

    public function like(Request $request, Shop $shop): Response
    {
        $request->user()->favoriteShops()->syncWithoutDetaching($shop);

        return response()->noContent();
    }

    public function dislike(Request $request, Shop $shop): Response
    {
        $request->user()->favoriteShops()->detach($shop);

        return response()->noContent();
    }
}
