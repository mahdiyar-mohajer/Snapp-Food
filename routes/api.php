<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\RestaurantsController;
use App\Http\Controllers\RestaurantController;
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
Route::post('logout',[AuthController::class,'logout']);

Route::middleware('auth:sanctum')->group(function(){

    Route::post('logout',[AuthController::class,'logout'],);

    Route::get('restaurants/{restaurant_id}', [RestaurantsController::class, 'getRestaurantInfo']);
    Route::get('restaurants', [RestaurantsController::class, 'getRestaurants']);

    Route::get('restaurants/{restaurant_id}/foods',[FoodController::class,'getFoods']);

});

// help :  https://stackoverflow.com/questions/66991646/how-to-resolve-unauthenticated-issue-in-postman-get-request



//use App\Http\Controllers\api\AddressController;
//use App\Http\Controllers\api\CartController;
//use App\Http\Controllers\api\CommentController;
//
//
//Route::middleware('auth:sanctum')->name('user.')->group(function () {
//    Route::post('/carts/{cart}/pay',[CartController::class,'pay']);
//    Route::get('/carts',[CartController::class,'index']);
//    Route::post('/carts/add',[CartController::class,'store']);
//    Route::patch('/carts/add',[CartController::class,'update']);
//
//    Route::get('/comments',[CommentController::class,'index']);
//    Route::post('/comments',[CommentController::class,'store']);
//
//    Route::post('/addresses/{address}',[AddressController::class,'setCurrentAddress']);
//    Route::apiResource('addresses', AddressController::class)->only(['index', 'store']);
//    Route::apiResource('restaurants', RestaurantController::class)->only(['index', 'show']);
//
//});


