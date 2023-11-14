<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resturants_resturant_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('resturant_id')->nullable();
            $table->unsignedBigInteger('resturant_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resturants_resturant_categories');
    }
};
