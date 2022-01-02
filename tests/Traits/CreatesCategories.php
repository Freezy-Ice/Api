<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Category;
use Illuminate\Support\Collection;

trait CreatesCategories
{
    public function createCategory(array $data = []): Category
    {
        /** @var Category $category */
        $category = Category::factory($data)->create();

        return $category;
    }

    public function createCategories(int $count = 5, array $data = []): Collection
    {
        return Category::factory($data)->count($count)->create();
    }
}
