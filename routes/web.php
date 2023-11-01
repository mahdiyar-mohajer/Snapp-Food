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

Route::get('login', [LoginController::class,'showLogin'])->name('show.login');
Route::post('login', [LoginController::class,'login'])->name('login');

Route::get('register', [RegisterController::class,'showRegister'])->name('show.register');
Route::post('register', [RegisterController::class,'register'])->name('register');


Route::get('/admin', [\App\Http\Controllers\AdminController::class,'index']);
Route::get('/admin/create', [\App\Http\Controllers\AdminController::class,'create'])->name('admin.create');
