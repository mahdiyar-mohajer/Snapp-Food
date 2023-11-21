<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\RestaurantsController;
use App\Http\Controllers\Api\UserController;
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
//Route::get('/hello', function () {
//    return "Hello World!";
//});
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

        Route::patch('personal-info', [UserController::class, 'update']);


    // region restaurants
    Route::prefix('restaurants')->group(function () {
        Route::get('/', [RestaurantsController::class, 'getRestaurants']);
        Route::get('{restaurant_id}', [RestaurantsController::class, 'getRestaurantInfo']);
        Route::get('{restaurant_id}/foods', [FoodController::class, 'getFoods']);
    });
    // endregion

    // region cart
    Route::prefix('cart')->group(function () {
        Route::post('add', [CartController::class, 'addItem']);
        Route::get('/', [CartController::class, 'viewCart']);
        Route::delete('remove/{food_id}', [CartController::class, 'removeItem']);
        Route::delete('clear', [CartController::class, 'clearCart']);
        Route::put('{foodId}', [CartController::class, 'updateCartItem']);
    });
    // endregion

    // region addresses
    Route::prefix('addresses')->group(function () {
        Route::get('/', [AddressController::class, 'index']);
        Route::post('/', [AddressController::class, 'store']);
        Route::post('current', [AddressController::class, 'setCurrent']);
    });
    // endregion

    // region comments
    Route::prefix('comments')->group(function () {
        Route::get('/', [CommentController::class, 'getComments']);
        Route::post('/', [CommentController::class, 'postComment']);
    });
    // endregion

    Route::post('/order/{orderId}/cancel', [CartController::class, 'cancelOrder']);
    Route::post('/order/{orderId}/confirm', [CartController::class, 'confirmOrder']);
    Route::get('/orders', [CartController::class, 'viewOrders']);
    Route::get('/order/{orderId}', [CartController::class, 'viewOrder']);
    Route::get('/order/{orderId}/status', [CartController::class, 'viewOrderStatus']);

});


//Route::post('register',[AuthController::class,'register'],);
//Route::post('login',[AuthController::class,'login'],);
//Route::post('logout',[AuthController::class,'logout']);
//
//Route::middleware('auth:sanctum')->group(function(){
//
//    Route::get('restaurants/{restaurant_id}', [RestaurantsController::class, 'getRestaurantInfo']);
//    Route::get('restaurants', [RestaurantsController::class, 'getRestaurants']);
//    Route::get('restaurants/{restaurant_id}/foods',[FoodController::class,'getFoods']);
//
//    Route::post('/cart/add', [CartController::class,'addItem']);
//    Route::get('/cart', [CartController::class, 'viewCart']);
//    Route::delete('/cart/remove/{food_id}', [CartController::class,'removeItem']);
//    Route::delete('/cart/clear', [CartController::class,'clearCart']);
//    Route::put('/cart/{foodId}', [CartController::class,'updateCartItem']);
//
//
//    Route::get('/addresses', [AddressController::class,'index']);
//    Route::post('/addresses', [AddressController::class,'store']);
//    Route::post('/addresses/current', [AddressController::class,'setCurrent']);
//
//    Route::patch('/personal-info', [UserController::class,'update']);
//
//    Route::get('/comments', [CommentController::class, 'getComments']);
//    Route::post('/comments', [CommentController::class, 'postComment']);
//
//});




