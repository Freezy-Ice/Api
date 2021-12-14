<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("flavor_product", function (Blueprint $table): void {
            $table->foreignId("flavor_id")->constrained()->onDelete("cascade");            
            $table->foreignId("product_id")->constrained()->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("flavor_product");
    }
};