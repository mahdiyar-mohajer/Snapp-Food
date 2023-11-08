<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRestaurantCategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FoodController;
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

});


//Route::middleware(['auth', 'role:seller'])->group(function () {
//    // Create a new food item
//    Route::get('/seller/create', [FoodController::class,'create'])->name('foods.create');
//    Route::post('/seller', [FoodController::class,'store'])->name('foods.store');
//    // Edit a food item
//    Route::get('/seller/{food}', [FoodController::class,'edit'])->name('foods.edit');
//    Route::put('/seller/{food}', [FoodController::class,'update'])->name('foods.update');
//    // Delete a food item
//    Route::delete('/seller/{food}', [FoodController::class,'destroy'])->name('foods.destroy');
//});
//
//
//Route::middleware(['auth', 'role:seller'])->group(function () {
//    Route::get('/seller', [SellerController::class, 'index'])->name('seller.dashboard');
//    Route::get('/seller/restaurant/profile', [RestaurantController::class ,'profile'])->name('resturant.profile');
//    Route::post('/seller/restaurant/profile', [RestaurantController::class ,'updateProfile'])->name('resturant.updateProfile');
//    Route::post('/seller/restaurant/profile/upload-picture', [RestaurantController::class ,'uploadPicture'])->name('resturant.uploadPicture');
//    Route::post('/restaurant/activate', [RestaurantController::class ,'toggleActivation'])->name('restaurant.toggleActivation');
//
//});

Route::middleware(['auth', 'role:seller'])->group(function () {
    // Seller Dashboard
    Route::get('/seller', [SellerController::class, 'index'])->name('seller.dashboard');

    // Restaurant Profile
    Route::get('/seller/restaurant/profile', [RestaurantController::class, 'profile'])->name('resturant.profile');
    Route::post('/seller/restaurant/profile', [RestaurantController::class, 'updateProfile'])->name('resturant.updateProfile');
    Route::post('/seller/restaurant/profile/upload-picture', [RestaurantController::class, 'uploadPicture'])->name('resturant.uploadPicture');
    Route::post('/restaurant/activate', [RestaurantController::class, 'toggleActivation'])->name('restaurant.toggleActivation');

    // Food Items
    Route::get('/seller/foods/create', [FoodController::class, 'create'])->name('foods.create');
    Route::post('/seller/foods', [FoodController::class, 'store'])->name('foods.store');
    Route::get('/seller/foods/{food}/edit', [FoodController::class, 'edit'])->name('foods.edit');
    Route::put('/seller/foods/{food}', [FoodController::class, 'update'])->name('foods.update');
    Route::delete('/seller/foods/{food}', [FoodController::class, 'destroy'])->name('foods.destroy');
    Route::get('/seller/foods/index', [FoodController::class, 'index'])->name('foods.index');
    Route::get('/seller/foods/{food}', [FoodController::class, 'show'])->name('foods.show');
    Route::get('/foods/search', [FoodController::class, 'liveSearch'])->name('foods.search');



});


