<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDiscountController;
use App\Http\Controllers\AdminFoodCategoryController;
use App\Http\Controllers\AdminRestaurantCategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    return view('welcome');
})->name('dashboard');


Route::middleware(['web', 'checkStatus'])->group(function () {

    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::get('login', [LoginController::class, 'showLogin'])->name('show.login');
Route::get('register', [RegisterController::class, 'showRegister'])->name('show.register');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::put('/admin/users/{id}/toggleStatus', [AdminController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::post('/admin/users/{id}/promote', [AdminController::class, 'promoteToAdmin'])->middleware(['auth', 'admin-promote'])->name('users.promoteToAdmin');

    Route::get('admin/restaurant-categories/create', [AdminRestaurantCategoryController::class, 'create'])->name('restaurant-categories.create');
    Route::post('admin/restaurant-categories', [AdminRestaurantCategoryController::class, 'store'])->name('restaurant-categories.store');
    Route::get('admin/restaurant-categories', [AdminRestaurantCategoryController::class, 'index'])->name('restaurant-categories.index');
    Route::get('admin/restaurant-categories/{category}/edit', [AdminRestaurantCategoryController::class, 'edit'])->name('restaurant-categories.edit');
    Route::put('admin/restaurant-categories/{category}', [AdminRestaurantCategoryController::class, 'update'])->name('restaurant-categories.update');
    Route::delete('admin/restaurant-categories/{category}', [AdminRestaurantCategoryController::class, 'destroy'])->name('restaurant-categories.destroy');


    Route::get('admin/food-categories/create', [AdminFoodCategoryController::class, 'create'])->name('food-categories.create');
    Route::post('admin/food-categories', [AdminFoodCategoryController::class, 'store'])->name('food-categories.store');
    Route::get('admin/food-categories', [AdminFoodCategoryController::class, 'index'])->name('food-categories.index');
    Route::get('admin/food-categories/{category}/edit', [AdminFoodCategoryController::class, 'edit'])->name('food-categories.edit');
    Route::put('admin/food-categories/{category}', [AdminFoodCategoryController::class, 'update'])->name('food-categories.update');
    Route::delete('admin/food-categories/{category}', [AdminFoodCategoryController::class, 'destroy'])->name('food-categories.destroy');

    Route::get('/admin/discounts', [AdminDiscountController::class, 'index'])->name('admin.discounts.index');
    Route::get('/admin/discounts/{discount}/edit', [AdminDiscountController::class, 'edit'])->name('admin.discounts.edit');
    Route::put('/admin/discounts/{discount}', [AdminDiscountController::class, 'update'])->name('admin.discounts.update');
    Route::delete('/admin/discounts/{discount}', [AdminDiscountController::class, 'destroy'])->name('admin.discounts.destroy');

    Route::post('admin/restaurant/activate', [RestaurantController::class, 'toggleActivation'])->name('admin.restaurant.toggleActivation');

    Route::resource('admin/restaurants', RestaurantController::class)->except('show');

});



Route::middleware(['auth', 'role:seller'])->group(function () {
    // Seller Dashboard
    Route::get('/seller', [SellerController::class, 'index'])->name('seller.dashboard');

    // Restaurant Profile
    Route::get('/seller/restaurant/profile', [RestaurantController::class, 'profile'])->name('resturant.profile');
    Route::post('/seller/restaurant/profile', [RestaurantController::class, 'updateProfile'])->name('resturant.updateProfile');
    Route::post('/seller/restaurant/profile/upload-picture', [RestaurantController::class, 'uploadPicture'])->name('resturant.uploadPicture');
    Route::post('/restaurant/activate', [RestaurantController::class, 'toggleActivation'])->name('restaurant.toggleActivation');
    Route::get('/seller/restaurant/coordinate',[RestaurantController::class, 'getCoordinates'])->name('get.coordinates');
    Route::post('/seller/restaurant/coordinate',[RestaurantController::class, 'setCoordinates'])->name('set.coordinates');
    // Food Items
    Route::get('/seller/foods/create', [FoodController::class, 'create'])->name('foods.create');
    Route::post('/seller/foods', [FoodController::class, 'store'])->name('foods.store');
    Route::get('/seller/foods/{food}/edit', [FoodController::class, 'edit'])->name('foods.edit');
    Route::put('/seller/foods/{food}', [FoodController::class, 'update'])->name('foods.update');
    Route::delete('/seller/foods/{food}', [FoodController::class, 'destroy'])->name('foods.destroy');
    Route::get('/seller/foods/index', [FoodController::class, 'index'])->name('foods.index');
    Route::get('/seller/foods/{food}', [FoodController::class, 'show'])->name('foods.show');

    Route::get('/seller/foods/{food}/discount/create', [DiscountController::class, 'create'])->name('discounts.create');
    Route::post('/seller/foods/{food}/discount', [DiscountController::class, 'store'])->name('discounts.store');
    Route::get('/seller/foods/{food}/discounts', [DiscountController::class, 'show'])->name('discounts.show');
    Route::get('/seller/foods/{food}/discount/{discount}/edit', [DiscountController::class, 'edit'])->name('discounts.edit');
    Route::put('/seller/foods/{food}/discount/{discount}', [DiscountController::class, 'update'])->name('discounts.update');
    Route::delete('/seller/foods/{food}/discount/{discount}', [DiscountController::class, 'destroy'])->name('discounts.destroy');
    Route::get('/seller/discounts', [DiscountController::class, 'index'])->name('discounts.index');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderId}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{orderId}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/archived', [OrderController::class, 'archived'])->name('seller.orders.archived');


    Route::get('/foods/search', [FoodController::class, 'liveSearch'])->name('foods.search');

});

