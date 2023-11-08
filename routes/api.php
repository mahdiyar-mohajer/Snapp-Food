<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\RestaurantsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/hello', function () {
    return "Hello World!";
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register'],);
Route::post('login',[AuthController::class,'login'],);

Route::middleware('auth:sanctum')->group(function(){

    Route::post('logout',[AuthController::class,'logout'],);

    Route::get('restaurants/{restaurant_id}',[RestaurantsController::class,'getRestaurantInfo']);
    Route::get('restaurants',[RestaurantsController::class,'getRestaurants']);

    Route::get('restaurants/{restaurant_id}/foods',[FoodController::class,'getFoods']);

});
