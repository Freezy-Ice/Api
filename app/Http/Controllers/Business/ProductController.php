<?php

declare(strict_types=1);

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\Business\ProductCollection;
use App\Http\Resources\Product\Business\ProductResource;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index(Shop $shop): JsonResource
    {
        $products = $shop->products()
            ->with(["flavors", "category"])
            ->get();

        return new ProductCollection($products);
    }

    public function store(ProductRequest $request, Shop $shop): JsonResource
    {
        $product = $shop->products()->create($request->getData());
        $product->flavors()->attach($request->getFlavors());

        return new ProductResource($product);
    }

    public function show(Shop $shop, Product $product): JsonResource
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Shop $shop, Product $product): JsonResource
    {
        $product->update($request->getData());

        $product->flavors()->detach();
        $product->flavors()->attach($request->getFlavors());

        return new ProductResource($product);
    }

    public function destroy(Shop $shop, Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
