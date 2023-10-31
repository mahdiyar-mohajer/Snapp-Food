<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('foods_party', function (Blueprint $table) {
            $table->id();
            $table->integer('count');
            $table->string('discount');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->unsignedBigInteger('food_id')->nullable();
            $table->unsignedBigInteger('resturant_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods_party');
    }
};
