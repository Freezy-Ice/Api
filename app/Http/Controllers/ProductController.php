<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    public function index(Shop $shop): JsonResource
    {
        $products = $shop->products()
            ->with(["flavors", "category"])
            ->get();

        return ProductResource::collection($products);
    }

    public function show(Shop $shop, Product $product): JsonResource
    {
        return new ProductResource($product);
    }
}
