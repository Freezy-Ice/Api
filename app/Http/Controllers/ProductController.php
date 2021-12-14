<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\IceCreamShop;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index(IceCreamShop $iceCreamShop): ProductCollection
    {
        return new ProductCollection($iceCreamShop->products);
    }

    public function store(ProductRequest $request, IceCreamShop $iceCreamShop): ProductResource
    {
        $product = $iceCreamShop->products()->create($request->getData());

        return new ProductResource($product);
    }

    public function show(IceCreamShop $iceCreamShop, Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, IceCreamShop $iceCreamShop, Product $product): ProductResource
    {
        $product->update($request->getData());
        $product->flavors()->sync($request->flavors);

        return new ProductResource($product); 
    }

    public function delete(IceCreamShop $iceCreamShop, Product $product): Response
    {
        $product->delete();

        return response(["message" => "Usunięto produkt"]);
    }
}