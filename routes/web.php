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

// Login route
Route::get('/login', [LoginController::class ,'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class ,'login']);

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class,'register']);


Route::get('/admin', [\App\Http\Controllers\AdminController::class,'index']);
Route::get('/admin/create', [\App\Http\Controllers\AdminController::class,'create'])->name('admin.create');
