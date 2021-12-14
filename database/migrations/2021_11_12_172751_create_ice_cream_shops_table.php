<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("ice_cream_shops", function (Blueprint $table): void {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            // $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string("name");
            $table->string("city");
            $table->string("address");
            $table->text("description");
            $table->float("lat", 6, 3)->nullable();
            $table->float("lng", 6, 3)->nullable();
            $table->boolean("accepted")->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("ice_cream_shops");
    }
};
