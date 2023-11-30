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
        Schema::table('bank', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
        Schema::table('resturants', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('bank')->onDelete('cascade');
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('shippment_id')->references('id')->on('order_ship')->onDelete('cascade');
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
        });
        Schema::table('order_ship', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
        Schema::table('foods_party', function (Blueprint $table) {
            $table->foreign('food_id')->references('id')->on('foods');
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
        });
        Schema::table('discounts', function (Blueprint $table) {
            $table->foreign('food_id')->references('id')->on('foods');
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
        });
        Schema::table('foods', function (Blueprint $table) {
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
        });
        Schema::table('foods_food_categories', function (Blueprint $table) {
            $table->foreign('food_id')->references('id')->on('foods');
            $table->foreign('food_category_id')->references('id')->on('food_categories')->onDelete('cascade');
        });
        Schema::table('resturants_resturant_categories', function (Blueprint $table) {
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
            $table->foreign('resturant_category_id')->references('id')->on('resturant_categories')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relations');
    }
};
