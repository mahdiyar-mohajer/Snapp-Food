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
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('resturant_id')->references('id')->on('resturants');
        });
        Schema::table('resturants', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('bank_id')->references('id')->on('bank');
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('shippment_id')->references('id')->on('order_ship');
            $table->foreign('resturant_id')->references('id')->on('resturants');
        });
        Schema::table('order_ship', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('food_id')->references('id')->on('foods');
            $table->foreign('order_id')->references('id')->on('orders');
        });
        Schema::table('foods_party', function (Blueprint $table) {
            $table->foreign('food_id')->references('id')->on('foods');
            $table->foreign('resturant_id')->references('id')->on('resturants');
        });
        Schema::table('discount', function (Blueprint $table) {
            $table->foreign('food_id')->references('id')->on('foods');
            $table->foreign('resturant_id')->references('id')->on('resturants');
        });
        Schema::table('foods', function (Blueprint $table) {
            $table->foreign('resturant_id')->references('id')->on('resturants');
        });
        Schema::table('foods_food_categories', function (Blueprint $table) {
            $table->foreign('food_id')->references('id')->on('foods');
            $table->foreign('food_category_id')->references('id')->on('food_categories');
        });
        Schema::table('resturants_resturant_categories', function (Blueprint $table) {
            $table->foreign('resturant_id')->references('id')->on('resturants');
            $table->foreign('category_id')->references('id')->on('resturant_categories');
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
