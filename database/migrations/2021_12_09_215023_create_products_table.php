<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("products", function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Shop::class)->constrained()->cascadeOnDelete();
            $table->string("name");
            $table->text("description");
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->integer("kcal");
            $table->integer("price");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("products");
    }
};
