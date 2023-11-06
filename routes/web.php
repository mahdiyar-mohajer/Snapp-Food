<?php

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
    // Your dashboard logic here
    return view('welcome');
})->name('dashboard');


Route::middleware(['web', 'checkStatus'])->group(function () {
    // Your authenticated routes here
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::get('login', [LoginController::class, 'showLogin'])->name('show.login');
Route::get('register', [RegisterController::class, 'showRegister'])->name('show.register');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/create', [\App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
    Route::put('/admin/users/{id}/toggleStatus', [\App\Http\Controllers\AdminController::class, 'toggleStatus'])->name('users.toggleStatus');

});

//Route::group(['middleware' => ['role:seller']], function () {
//    Route::get('/seller', [\App\Http\Controllers\SellerController::class, 'index'])->name('seller.dashboard');
//});
//,'checkRestaurantProfile'
Route::middleware(['auth', 'role:seller'])->group(function () {

    // Create a new food item
    Route::get('/seller/create', [FoodController::class,'create'])->name('foods.create');
    Route::post('/seller', [FoodController::class,'store'])->name('foods.store');

    // Edit a food item
    Route::get('/seller/{food}', [FoodController::class,'edit'])->name('foods.edit');
    Route::put('/seller/{food}', [FoodController::class,'update'])->name('foods.update');

    // Delete a food item
    Route::delete('/seller/{food}', [FoodController::class,'destroy'])->name('foods.destroy');
});
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller', [SellerController::class, 'index'])->name('seller.dashboard');

    Route::get('/seller/restaurant/profile', [RestaurantController::class ,'profile'])->name('resturant.profile'); // Fixed the route name
    Route::post('/seller/restaurant/profile', [RestaurantController::class ,'updateProfile'])->name('resturant.updateProfile'); // Fixed the route name
});
