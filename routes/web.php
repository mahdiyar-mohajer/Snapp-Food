<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::group(['middleware' => ['role:seller']], function () {
    Route::get('/seller', [\App\Http\Controllers\SellerController::class, 'index'])->name('seller.dashboard');
});

