<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $categorys = Category::query()->paginate($request->query("perPage"));

        return new CategoryCollection($categorys);
    }

    public function store(CategoryRequest $request): JsonResource
    {
        $category = Category::query()->create($request->getData());

        return new CategoryResource($category);
    }

    public function show(Category $category): JsonResource
    {
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category): JsonResource
    {
        $category->update($request->getData());

        return new CategoryResource($category);
    }

    public function destroy(Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }
}
