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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('payment')->default(null)->nullable();
            $table->string('total_price');
            $table->enum('status', ['PENDING', 'ACCEPT', 'PREPARING', 'DONE'])->default('PENDING');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('resturant_id')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('shippment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
