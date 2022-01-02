<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Resources\PaginatedCollection;
use App\Http\Resources\Shop\Admin\ShopCollection;
use App\Http\Resources\Shop\Admin\ShopResource;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ShopController extends Controller
{
    public function index(Request $request): PaginatedCollection
    {
        $shops = Shop::query()->unaccepted()->paginate($request->query("perPage"));

        return new ShopCollection($shops);
    }

    public function show(Shop $shop): JsonResource
    {
        return new ShopResource($shop);
    }

    public function accept(Shop $shop): Response
    {
        $shop->accept();

        return response()->noContent();
    }
}
