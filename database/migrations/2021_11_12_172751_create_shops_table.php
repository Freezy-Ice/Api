<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("shops", function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string("name");
            $table->foreignIdFor(City::class)->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists("shops");
    }
};
