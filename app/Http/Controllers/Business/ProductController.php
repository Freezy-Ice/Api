<?php

declare(strict_types=1);

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index(Shop $shop): JsonResource
    {
        return new ProductCollection($shop->products);
    }

    public function store(ProductRequest $request, Shop $shop): JsonResource
    {
        $product = $shop->products()->create($request->getData());
        $product->flavors()->attach($request->getFlavors());

        return new ProductResource($product);
    }

    public function show(Product $product): JsonResource
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product): JsonResource
    {
        $product->update($request->getData());

        $product->flavors()->detach();
        $product->flavors()->attach($request->getFlavors());

        return new ProductResource($product);
    }

    public function destroy(Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
