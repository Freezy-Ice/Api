<?php

declare(strict_types=1);

use App\Models\IceCreamShop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("opening_hours", function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(IceCreamShop::class)->constrained()->cascadeOnDelete();
            $table->string("day");
            $table->string("from")->nullable();
            $table->string("to")->nullable();
            $table->boolean("open")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("opening_hours");
    }
};
