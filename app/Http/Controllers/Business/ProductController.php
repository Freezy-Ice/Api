<?php

declare(strict_types=1);

namespace App\Http\Controllers\Business;

use App\Events\ProductCreated;
use App\Events\ProductDeleted;
use App\Events\ProductUpdated;
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
        /** @var Product $product */
        $product = $shop->products()->create($request->getData());
        $product->flavors()->attach($request->getFlavors());

        if ($request->getImage() !== null) {
            $product->image()->save($request->getImage());
        }

        event(new ProductCreated($product));

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

        if ($request->getImage() !== null) {
            $product->image()->delete();
            $product->image()->save($request->getImage());
        }

        event(new ProductUpdated($product));

        return new ProductResource($product);
    }

    public function destroy(Shop $shop, Product $product): Response
    {
        $product->delete();

        event(new ProductDeleted($product));

        return response()->noContent();
    }
}
